<?php

namespace Planet\PlanetBundle\Controller;

use eZ\Publish\Core\MVC\Symfony\Controller\Controller,
    Symfony\Component\HttpFoundation\Response,
    eZ\Publish\API\Repository\Values\Content\Query,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion,
    eZ\Publish\API\Repository\Values\Content\Query\SortClause,
    DateTime;


class PlanetController extends Controller
{
    /**
     * Array of the already loaded locations
     *
     * @var \eZ\Publish\Core\Repository\Values\Content\Location[]
     */
    protected $locationsMap = array();

    /**
     * Build the response so that depending on settings it's cacheable
     *
     * @param string $etag
     * @param DateTime $lastModified
     * @return \Symfony\Component\HttpFoundation\Response
     * @todo taken for ViewController, should be defined in one of the base;
     * controller.
     */
    protected function buildResponse( $etag, DateTime $lastModified )
    {
        $request = $this->getRequest();
        $response = new Response();
        if ( $this->getParameter( 'content.view_cache' ) === true )
        {
            $response->setPublic();
            $response->setEtag( $etag );

            // If-None-Match is the request counterpart of Etag response header
            // Making the response to vary against it ensures that an HTTP
            // reverse proxy caches the different possible variations of the
            // response as it can depend on user role for instance.
            if ( $request->headers->has( 'If-None-Match' )
                && $this->getParameter( 'content.ttl_cache' ) === true )
            {
                $response->setVary( 'If-None-Match' );
                $response->setMaxAge(
                    $this->getParameter( 'content.default_ttl' )
                );
            }

            $response->setLastModified( $lastModified );
        }
        return $response;
    }

    /**
     * Loads a location by its id and store it in a local map
     *
     * @param int id
     * @return \eZ\Publish\Core\Repository\Values\Content\Location
     */
    protected function loadLocation( $id )
    {
        if ( !isset( $this->locationsMap[$id] ) )
        {
            $this->locationsMap[$id] = $this->getRepository()
                ->getLocationService()
                ->loadLocation( $id );
        }
        return $this->locationsMap[$id];
    }

    /**
     * Searches for content under $parentLocationId being of the specified
     * types sorted with $sortClauses
     *
     * @param int $parentLocationId
     * @param array $contentTypeIds
     * @param array $sortClauses
     * @return \eZ\Publish\API\Repository\Values\Content\Search\SearchResult
     */
    protected function contentList(
        $parentLocationId, array $contentTypeIds, array $sortClauses = array()
    )
    {
        $searchService = $this->getRepository()->getSearchService();
        $query = new Query();
        $query->criterion = new Criterion\LogicalAND(
            array(
                new Criterion\ParentLocationId( $parentLocationId ),
                new Criterion\ContentTypeId( $contentTypeIds ),
            )
        );
        if ( !empty( $sortClauses ) )
        {
            $query->sortClauses = $sortClauses;
        }
        return $searchService->findContent( $query );
    }

    /**
     * Builds the top menu ie first level items of classes folder, page or
     * contact.
     *
     * @todo do NOT hard code the types id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function topMenu()
    {
        $locationService = $this->getRepository()->getLocationService();

        $rootLocationId = $this->container->getParameter(
            'planet.root_location_id'
        );
        $root = $this->loadLocation( $rootLocationId );

        $response = $this->buildResponse(
            __METHOD__ . $rootLocationId,
            $root->contentInfo->modificationDate
        );
        if ( $response->isNotModified( $this->getRequest() ) )
        {
            return $response;
        }

        $results = $this->contentList(
            $rootLocationId,
            array( 1, 20, 21 ),
            array( new SortClause\LocationPriority() )
        );
        $items = array( $root );
        foreach ( $results->searchHits as $hit )
        {
            $location = $locationService->loadLocation(
                $hit->valueObject->contentInfo->mainLocationId
            );
            $items[] = $location;
        }

        return $this->render(
            'PlanetBundle:parts:top_menu.html.twig',
            array(
                'rootLocationId' => $rootLocationId,
                'items' => $items,
            ),
            $response
        );
    }

    /**
     * Builds the site list block
     *
     * @todo do NOT hard code the site type id
     * @todo sort by modified_subnode instead of last modified
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function siteList()
    {
        $locationService = $this->getRepository()->getLocationService();
        $blogsLocationId = $this->container->getParameter(
            'planet.blogs_location_id'
        );
        $blogs = $this->loadLocation( $blogsLocationId );

        $response = $this->buildResponse(
            __METHOD__ . $blogsLocationId,
            $blogs->contentInfo->modificationDate
        );
        if ( $response->isNotModified( $this->getRequest() ) )
        {
            return $response;
        }

        $results = $this->contentList(
            $blogsLocationId,
            array( 17 ),
            array( new SortClause\DateModified( Query::SORT_DESC ) )
        );
        $sites = array();
        foreach ( $results->searchHits as $hit )
        {
            $location = $locationService->loadLocation(
                $hit->valueObject->contentInfo->mainLocationId
            );
            $sites[] = $location;
        }

        return $this->render(
            'PlanetBundle:parts:site_list.html.twig',
            array(
                'sites' => $sites,
                'blogs' => $blogs,
            ),
            $response
        );
    }

    /**
     * Builds the rich text block
     *
     * @todo do NOT hard code the rich text type id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function richTextBlock()
    {
        $rootLocationId = $this->container->getParameter(
            'planet.root_location_id'
        );
        $root = $this->loadLocation( $rootLocationId );

        $response = $this->buildResponse(
            __METHOD__ . $rootLocationId,
            $root->contentInfo->modificationDate
        );
        if ( $response->isNotModified( $this->getRequest() ) )
        {
            return $response;
        }

        $contentService = $this->getRepository()->getContentService();
        $results = $this->contentList(
            $rootLocationId,
            array( 23 )
        );
        $blocks = array();
        foreach ( $results->searchHits as $hit )
        {
            $blocks[] = $contentService->loadContent(
                $hit->valueObject->contentInfo->id
            );
        }

        return $this->render(
            'PlanetBundle:parts:rich_text_block.html.twig',
            array(
                'blocks' => $blocks,
            ),
            $response
        );

    }

    /**
     * Returns the version of eZ Publish (taken from legacy eZPublishSDK)
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function poweredBy()
    {
        $response = new Response();
        $response->setPublic();
        $response->setContent( \eZPublishSDK::version() );
        return $response;
    }


}


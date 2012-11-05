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
     * Searches for content under $parentLocationId at any level being of the
     * specified types sorted with $sortClauses
     *
     * @param int $parentLocationId
     * @param array $contentTypeIds
     * @param array $sortClauses
     * @param int $limit
     * @param int $offset
     * @return \eZ\Publish\API\Repository\Values\Content\Search\SearchResult
     */
    protected function contentTree(
        $parentLocationId, array $contentTypeIds, array $sortClauses = array(), $limit = 0, $offset = 0
    )
    {
        $searchService = $this->getRepository()->getSearchService();
        $query = new Query();
        $query->criterion = new Criterion\LogicalAND(
            array(
                new Criterion\Subtree( $parentLocationId ),
                new Criterion\ContentTypeId( $contentTypeIds ),
            )
        );
        if ( !empty( $sortClauses ) )
        {
            $query->sortClauses = $sortClauses;
        }
        $query->limit = $limit;
        $query->offset = $offset;
        return $searchService->findContent( $query );
    }

    /**
     * Builds the top menu ie first level items of classes folder, page or
     * contact.
     *
     * @param int|null $selected the selected location id
     * @todo do NOT hard code the types id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function topMenu( $selected = null )
    {
        $locationService = $this->getRepository()->getLocationService();

        $rootLocationId = $this->container->getParameter(
            'planet.tree.root'
        );
        $root = $this->loadLocation( $rootLocationId );

        $response = $this->buildResponse(
            __METHOD__ . $rootLocationId . '-' . $selected,
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
                'selected' => $selected,
                'rootLocationId' => $rootLocationId,
                'items' => $items,
            ),
            $response
        );
    }

    /**
     * Builds the post list under $rootLocationId and run the $viewType on each
     * of them
     *
     * @param int $rootLocationId
     * @param string $viewType
     * @param int $limit
     * @param int $offset
     * @todo do NOT hard code the post type id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postList( $rootLocationId, $viewType, $limit = null, $offset = 0 )
    {
        $root = $this->loadLocation( $rootLocationId );
        $response = $this->buildResponse(
            __METHOD__ . $rootLocationId,
            $root->contentInfo->modificationDate
        );
        if ( $response->isNotModified( $this->getRequest() ) )
        {
            return $response;
        }
        $locationService = $this->getRepository()->getLocationService();
        $results = $this->contentTree(
            $root->pathString,
            array( 18 ),
            array( new SortClause\DatePublished( Query::SORT_DESC ) ),
            $limit,
            $offset
        );
        $posts = array();
        foreach ( $results->searchHits as $hit )
        {
            $posts[] = $hit->valueObject;
        }
        return $this->render(
            'PlanetBundle::posts_list.html.twig',
            array(
                'total' => $results->totalCount,
                'offset' => $offset,
                'root' => $this->loadLocation(
                    $this->container->getParameter(
                        'planet.tree.root'
                    )
                ),
                'posts' => $posts,
                'viewType' => $viewType,
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
        $blogsLocationId = $this->container->getParameter(
            'planet.tree.blogs'
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

        $contentService = $this->getRepository()->getContentService();
        $results = $this->contentList(
            $blogsLocationId,
            array( 17 ),
            array( new SortClause\DateModified( Query::SORT_DESC ) )
        );
        $sites = array();
        foreach ( $results->searchHits as $hit )
        {
            $sites[] = $contentService->loadContent(
                $hit->valueObject->id
            );
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
            'planet.tree.root'
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
     * Builds the planetarium block
     *
     * @todo do NOT hard code the site type id
     * @return \Symfony\Component\HttpFoundation\Response
     */   
    public function planetarium()
    {
        $planetariumLocationId = $this->container->getParameter(
            'planet.tree.planetarium'
        );
        $planetarium = $this->loadLocation( $planetariumLocationId );

        $response = $this->buildResponse(
            __METHOD__ . $planetariumLocationId,
            $planetarium->contentInfo->modificationDate
        );
        if ( $response->isNotModified( $this->getRequest() ) )
        {
            return $response;
        }

        $contentService = $this->getRepository()->getContentService();
        $results = $this->contentList(
            $planetariumLocationId,
            array( 17 )
        );
        $planets = array();
        foreach ( $results->searchHits as $hit )
        {
            $planets[] = $contentService->loadContent(
                $hit->valueObject->contentInfo->id
            );
        }

        return $this->render(
            'PlanetBundle:parts:planetarium.html.twig',
            array(
                'planetarium' => $planetarium,
                'planets' => $planets,
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


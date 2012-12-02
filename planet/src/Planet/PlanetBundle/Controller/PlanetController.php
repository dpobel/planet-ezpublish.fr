<?php

namespace Planet\PlanetBundle\Controller;

use eZ\Publish\Core\MVC\Symfony\Controller\Content\ViewController as Controller,
    Symfony\Component\HttpFoundation\Response,
    eZ\Publish\API\Repository\Values\Content\Query,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion,
    eZ\Publish\API\Repository\Values\Content\Query\SortClause,
    DateTime;


class PlanetController extends Controller
{

    /**
     * Builds the top menu ie first level items of classes folder, page or
     * contact.
     *
     * @param int|null $selected the selected location id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function topMenu( $selected = null )
    {
        $locationService = $this->getRepository()->getLocationService();

        $rootLocationId = $this->container->getParameter(
            'planet.tree.root'
        );
        $root = $locationService->loadLocation( $rootLocationId );

        $response = $this->buildResponse(
            __METHOD__ . $rootLocationId . '-' . $selected,
            $root->contentInfo->modificationDate
        );
        if ( $response->isNotModified( $this->getRequest() ) )
        {
            return $response;
        }

        $results = $locationService->contentList(
            $rootLocationId,
            array( 'folder', 'contact', 'page' ),
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
     * @param bool $navigator
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postList( $rootLocationId, $viewType, $limit = null, $offset = 0, $navigator = true )
    {
        $locationService = $this->getRepository()->getLocationService();
        $root = $locationService->loadLocation( $rootLocationId );
        $response = $this->buildResponse(
            __METHOD__ . $rootLocationId,
            $root->contentInfo->modificationDate
        );
        if ( $response->isNotModified( $this->getRequest() ) )
        {
            return $response;
        }
        $results = $locationService->contentTree(
            $rootLocationId,
            array( 'post' ),
            array( new SortClause\Field( 'post', 'date', Query::SORT_DESC ) ),
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
                'root' => $locationService->loadLocation(
                    $this->container->getParameter(
                        'planet.tree.root'
                    )
                ),
                'posts' => $posts,
                'viewType' => $viewType,
                'navigator' => (bool) $navigator,
            ),
            $response
        );


    }

    /**
     * Builds the site list block
     *
     * @todo sort by modified_subnode instead of last modified
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function siteList()
    {
        $blogsLocationId = $this->container->getParameter(
            'planet.tree.blogs'
        );
        $locationService = $this->getRepository()->getLocationService();
        $blogs = $locationService->loadLocation( $blogsLocationId );

        $response = $this->buildResponse(
            __METHOD__ . $blogsLocationId,
            $blogs->contentInfo->modificationDate
        );
        if ( $response->isNotModified( $this->getRequest() ) )
        {
            return $response;
        }

        $contentService = $this->getRepository()->getContentService();
        $results = $locationService->contentList(
            $blogsLocationId,
            array( 'site' ),
            array(
                new SortClause\Field(
                    'site', 'modification_date', Query::SORT_DESC
                )
            )
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
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function richTextBlock()
    {
        $rootLocationId = $this->container->getParameter(
            'planet.tree.root'
        );
        $locationService = $this->getRepository()->getLocationService();
        $root = $locationService->loadLocation( $rootLocationId );

        $response = $this->buildResponse(
            __METHOD__ . $rootLocationId,
            $root->contentInfo->modificationDate
        );
        if ( $response->isNotModified( $this->getRequest() ) )
        {
            return $response;
        }

        $contentService = $this->getRepository()->getContentService();
        $results = $locationService->contentList(
            $rootLocationId,
            array( 'rich_block' )
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
     * @return \Symfony\Component\HttpFoundation\Response
     */   
    public function planetarium()
    {
        $planetariumLocationId = $this->container->getParameter(
            'planet.tree.planetarium'
        );
        $locationService = $this->getRepository()->getLocationService();
        $planetarium = $locationService->loadLocation( $planetariumLocationId );

        $response = $this->buildResponse(
            __METHOD__ . $planetariumLocationId,
            $planetarium->contentInfo->modificationDate
        );
        if ( $response->isNotModified( $this->getRequest() ) )
        {
            return $response;
        }

        $contentService = $this->getRepository()->getContentService();
        $results = $locationService->contentList(
            $planetariumLocationId,
            array( 'site' )
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


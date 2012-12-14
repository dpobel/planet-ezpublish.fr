<?php

namespace Planet\PlanetBundle\Controller;

use Planet\PlanetBundle\Controller\ViewController as Controller,
    Planet\PlanetBundle\Operation\Manager as OperationManager,
    Symfony\Component\HttpFoundation\Response,
    eZ\Publish\Core\MVC\Symfony\View\Manager as ViewManager,
    eZ\Publish\API\Repository\Values\Content\Query,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion,
    eZ\Publish\API\Repository\Values\Content\Query\SortClause,
    ezcFeed,
    eZPlaneteUtils,
    DateTime;


class PlanetController extends Controller
{

    /**
     * The operation manager
     *
     * @var \Planet\PlanetBundle\Operation\Manager
     */
    protected $operation;

    public function __construct( ViewManager $view, OperationManager $operation )
    {
        parent::__construct( $view );
        $this->operation = $operation;
    }


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
        $response->headers->set( 'X-Location-Id', $rootLocationId );
        if ( $response->isNotModified( $this->getRequest() ) )
        {
            return $response;
        }

        $items = $this->operation->locationList(
            $rootLocationId,
            array( 'folder', 'contact', 'page' ),
            array( new SortClause\LocationPriority() )
        );
        array_unshift( $items, $root );

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
     * @param int $paginationLocationId
     * @param string $viewType
     * @param int $limit
     * @param int $offset
     * @param bool $navigator
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function postList( $rootLocationId, $paginationLocationId, $viewType, $limit = null, $offset = 0, $navigator = true )
    {
        $locationService = $this->getRepository()->getLocationService();
        $root = $locationService->loadLocation( $rootLocationId );
        $response = $this->buildResponse(
            __METHOD__ . $rootLocationId,
            $root->contentInfo->modificationDate
        );
        $response->headers->set( 'X-Location-Id', $rootLocationId );
        if ( $response->isNotModified( $this->getRequest() ) )
        {
            return $response;
        }
        $results = $this->operation->searchTree(
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
                'root' => $root,
                'paginationRoot' => $locationService->loadLocation( $paginationLocationId ),
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
        $response->headers->set( 'X-Location-Id', $blogsLocationId );
        if ( $response->isNotModified( $this->getRequest() ) )
        {
            return $response;
        }

        $contentService = $this->getRepository()->getContentService();
        $sites = $this->operation->contentList(
            $blogsLocationId,
            array( 'site' ),
            array(
                new SortClause\Field(
                    'site', 'modification_date', Query::SORT_DESC
                )
            )
        );
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
        $response->headers->set( 'X-Location-Id', $rootLocationId );
        if ( $response->isNotModified( $this->getRequest() ) )
        {
            return $response;
        }

        $contentService = $this->getRepository()->getContentService();
        $blocks = $this->operation->contentList(
            $rootLocationId,
            array( 'rich_block' )
        );

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
        $response->headers->set( 'X-Location-Id', $planetariumLocationId );
        if ( $response->isNotModified( $this->getRequest() ) )
        {
            return $response;
        }

        $contentService = $this->getRepository()->getContentService();
        $planets = $this->operation->contentList(
            $planetariumLocationId,
            array( 'site' )
        );

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
        $response->setContent(
            \eZPublishSDK::version( true, false, false )
            . " (Github clone du 04/12/12)"
        );
        return $response;
    }

    /**
     * Build the RSS2 feed of the planet
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function feed()
    {
        $locationService = $this->getRepository()->getLocationService();
        $blogsLocationId = $this->container->getParameter(
            'planet.tree.blogs'
        );
        $posts = $this->operation->searchTree(
            $blogsLocationId,
            array( 'post' ),
            array(
                new SortClause\Field( 'post', 'date', Query::SORT_DESC ),
            ),
            (int)$this->container->getParameter( 'planet.feed.posts' )
        );
        $response = $this->buildResponse(
            __FUNCTION__ . $blogsLocationId,
            $posts->searchHits[0]->valueObject->contentInfo->modificationDate
        );
        $response->headers->set( 'X-Location-Id', $blogsLocationId );
        if ( $response->isNotModified( $this->getRequest() ) )
        {
            return $response;
        }
        $blogs = $locationService->loadLocation( $blogsLocationId );

        $feed = new ezcFeed();
        $feed->title = $this->container->getParameter(
            'planet.feed.title'
        );
        $feed->description = '';
        $feed->published = time();
        $feed->updated = $blogs->contentInfo->modificationDate;
        $link = $feed->add( 'link' );
        $link->href = 'http://' .
            $this->container->getParameter( 'planet.feed.url_base' );

        foreach ( $posts->searchHits as $hit )
        {
            $post = $hit->valueObject;
            $location = $locationService->loadLocation(
                $post->contentInfo->mainLocationId
            );
            $item = $feed->add( 'item' );
            $item->title = htmlspecialchars(
                $post->contentInfo->name, ENT_NOQUOTES, 'UTF-8'
            );
            $guid = $item->add( 'id' );
            $guid->id = $location->remoteId;
            $guid->isPermaLink = "false";
            $item->link = htmlspecialchars(
                $post->getField( 'url' )->value->link,
                ENT_NOQUOTES, 'UTF-8'
            );
            $item->pubDate = $post->getField( 'date' )->value->value;
            $item->published = $post->getField( 'date' )->value->value;
            $item->description = eZPlaneteUtils::cleanRewriteXHTML(
                $post->getField( 'html' )->value->text,
                $post->getField( 'url' )->value->link
            );
            $dublinCore = $item->addModule( 'DublinCore' );
            $creator = $dublinCore->add( 'creator' );
            $parentLocation =
            $creator->name = htmlspecialchars(
                $locationService->loadLocation(
                    $location->parentLocationId
                )->contentInfo->name,
                ENT_NOQUOTES, 'UTF-8'
            );
        }

        $xml = $feed->generate( 'rss2' );
        $response->headers->set( 'content-type', $feed->getContentType() );
        $response->setContent( $xml );
        return $response;
    }

}


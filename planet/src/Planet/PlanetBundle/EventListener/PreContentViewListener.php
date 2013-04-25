<?php

namespace Planet\PlanetBundle\EventListener;

use eZ\Publish\Core\MVC\Symfony\Event\PreContentViewEvent;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause;
use eZ\Publish\API\Repository\Repository;
use Planet\PlanetBundle\Helper\Content as ContentHelper;

class PreContentViewListener
{
    /**
     * The repository
     * 
     * @var \eZ\Publish\API\Repository\Repository
     */
    protected $repository;

    /**
     * @var Planet\PlanetBundle\Helper\Content
     */
    protected $contentHelper;

    public function __construct( Repository $repository, ContentHelper $helper )
    {
        $this->repository = $repository;
        $this->contentHelper = $helper;
    }

    public function onPreContentView( PreContentViewEvent $event )
    {
        $view = $event->getContentView();
        $identifier = $view->getTemplateIdentifier();
        if (
            is_string( $identifier )
            && strpos( $identifier, 'full:folder' ) !== false
            && $view->hasParameter( 'location' )
        )
        {
            $folder = $view->getParameter( 'location' );
            $locationService = $this->repository->getLocationService();
            $result = $this->contentHelper->contentList(
                $folder->id,
                array( 'site' ),
                array(
                    new SortClause\Field(
                        'site', 'modification_date', Query::SORT_DESC
                    )
                )
            );
            $sites = array();
            foreach ( $result->searchHits as $hit )
            {
                $sites[] = $locationService->loadLocation(
                    $hit->valueObject->contentInfo->mainLocationId
                );
            }
            $view->addParameters( array( 'sites' => $sites ) );
        }
        elseif (
            is_string( $identifier )
            && strpos( $identifier, 'full:post' ) !== false
            && $view->hasParameter( 'location' )
        )
        {
            $locationService = $this->repository->getLocationService();
            $post = $view->getParameter( 'location' );
            $parent = $this->repository
                ->getLocationService()
                ->loadLocation( $post->parentLocationId );
            $view->addParameters(
                array(
                    'parent' => $parent,
                    'parentContent' => $this->repository
                        ->getContentService()
                        ->loadContent( $parent->contentInfo->id ),
                )
            );
        }
    }

}

<?php

namespace Planet\PlanetBundle\EventListener;

use eZ\Publish\Core\MVC\Symfony\Event\PreContentViewEvent,
    eZ\Publish\API\Repository\Values\Content\Query,
    eZ\Publish\API\Repository\Values\Content\Query\SortClause,
    eZ\Publish\API\Repository\Repository;

class PreContentViewListener
{
    /**
     * The repository
     * 
     * @var \eZ\Publish\API\Repository\Repository
     */
    protected $repository;

    public function __construct( Repository $repository )
    {
        $this->repository = $repository;
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
            $result = $locationService->contentList(
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

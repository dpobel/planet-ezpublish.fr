<?php

namespace Planet\PlanetBundle\EventListener;

use eZ\Publish\Core\MVC\Symfony\Event\PreContentViewEvent,
    eZ\Publish\API\Repository\Values\Content\Query,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion,
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
            $searchService = $this->repository->getSearchService();
            $query = new Query();
            $query->criterion = new Criterion\LogicalAnd(
                array(
                    new Criterion\ParentLocationId( $folder->id ),
                    new Criterion\ContentTypeId( array( 17 ) ),
                )
            );
            $query->sortClauses = array(
                new SortClause\DateModified( Query::SORT_DESC )
            );
            $result = $searchService->findContent( $query );
            $sites = array();
            foreach ( $result->searchHits as $hit )
            {
                $sites[] = $locationService->loadLocation(
                    $hit->valueObject->contentInfo->mainLocationId
                );
            }
            $view->addParameters( array( 'sites' => $sites ) );
        }
    }

}

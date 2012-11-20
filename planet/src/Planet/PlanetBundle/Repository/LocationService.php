<?php

namespace Planet\PlanetBundle\Repository;

use eZ\Publish\Core\SignalSlot\LocationService as SignalSlotLocationService,
    eZ\Publish\API\Repository\Values\Content\Query,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion,
    eZ\Publish\API\Repository\Repository as RepositoryInterface,
    eZ\Publish\API\Repository\LocationService as LocationServiceInterface,
    eZ\Publish\Core\SignalSlot\SignalDispatcher;

class LocationService extends SignalSlotLocationService
{

    protected $locationsMap = array();

    public function __construct(
        RepositoryInterface $repository,
        LocationServiceInterface $service,
        SignalDispatcher $signalDispatcher
    )
    {
        parent::__construct( $service, $signalDispatcher );
        $this->repository = $repository;
    }

    public function loadLocation( $locationId )
    {
        if ( !isset( $this->locationsMap[$locationId] ) )
        {
            $this->locationsMap[$locationId] = parent::loadLocation( $locationId );
        }
        return $this->locationsMap[$locationId];
    }

    /**
     * Searches for content under $parentLocationId being of the specified
     * types sorted with $sortClauses
     *
     * @param int $parentLocationId
     * @param array $typeIdentifiers
     * @param array $sortClauses
     * @param int|null $limit
     * @param int $offset
     * @return \eZ\Publish\API\Repository\Values\Content\Search\SearchResult
     */
    public function contentList(
        $parentLocationId, array $typeIdentifiers = array(),
        array $sortClauses = array(), $limit = null, $offset = 0
    )
    {
        $searchService = $this->repository->getSearchService();
        $query = new Query();
        $query->criterion = new Criterion\LogicalAnd(
            array(
                new Criterion\ParentLocationId( $parentLocationId ),
                new Criterion\ContentTypeId(
                    $this->typeIdentifiersToIds( $typeIdentifiers )
                )
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
     * Searches for content under $parentLocationId at any level being of the
     * specified types sorted with $sortClauses
     *
     * @param int $parentLocationId
     * @param array $typeIdentifiers
     * @param array $sortClauses
     * @param int|null $limit
     * @param int $offset
     * @return \eZ\Publish\API\Repository\Values\Content\Search\SearchResult
     */
    public function contentTree(
        $parentLocationId, array $typeIdentifiers = array(),
        array $sortClauses = array(), $limit = null, $offset = 0
    )
    {
        $parentLocation = $this->loadLocation( $parentLocationId );
        $searchService = $this->repository->getSearchService();
        $query = new Query();
        $query->criterion = new Criterion\LogicalAnd(
            array(
                new Criterion\Subtree( $parentLocation->pathString ),
                new Criterion\ContentTypeId(
                    $this->typeIdentifiersToIds( $typeIdentifiers )
                ),
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


    protected function typeIdentifiersToIds( array $identifiers )
    {
        // TODO add in memory cache
        $ids = array();
        foreach ( $identifiers as $identifier )
        {
            if ( is_numeric( $identifier ) )
            {
                $ids[] = $identifier;
            }
            else
            {
                $ids[] = $this
                    ->repository
                    ->getContentTypeService()
                    ->loadContentTypeByIdentifier( $identifier )
                    ->id;
            }
        }
        return $ids;
    }

}

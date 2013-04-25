<?php

namespace Planet\PlanetBundle\Helper;

use eZ\Publish\Core\SignalSlot\LocationService as SignalSlotLocationService;
use eZ\Publish\API\Repository\Values\Content\Query;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Repository as RepositoryInterface;
use eZ\Publish\API\Repository\LocationService as LocationServiceInterface;
use eZ\Publish\Core\SignalSlot\SignalDispatcher;

class Content
{
    /**
     * @var eZ\Publish\API\Repository\Repository
     */
    protected $repository;

    public function __construct( RepositoryInterface $repository )
    {
        $this->repository = $repository;
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
        $locationService = $this->repository->getLocationService();
        $parentLocation = $locationService->loadLocation( $parentLocationId );
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

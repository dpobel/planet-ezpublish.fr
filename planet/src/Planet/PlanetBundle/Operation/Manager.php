<?php

namespace Planet\PlanetBundle\Operation;

use eZ\Publish\API\Repository\Values\Content\Query,
    eZ\Publish\API\Repository\Values\Content\Query\Criterion,
    eZ\Publish\API\Repository\Repository;

class Manager
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

    /**
     * Searches for content under $parentLocationId being of the specified
     * types sorted with $sortClauses and returns an array of Location
     *
     * @param int $parentLocationId
     * @param array $typeIdentifiers
     * @param array $sortClauses
     * @param int|null $limit
     * @param int $offset
     * @return \eZ\Publish\API\Repository\Values\Content\Location[]
     */
    public function locationList(
        $parentLocationId, array $typeIdentifiers = array(),
        array $sortClauses = array(), $limit = null, $offset = 0
    )
    {
        $search = $this->searchList(
            $parentLocationId, $typeIdentifiers,
            $sortClauses, $limit, $offset
        );
        $locationService = $this->repository->getLocationService();
        $results = array();
        foreach ( $search->searchHits as $hit )
        {
            $results[] = $locationService->loadLocation(
                $hit->valueObject->contentInfo->mainLocationId
            );
        }
        return $results;
    }

    /**
     * Searches for content under $parentLocationId at any level being of the
     * specified types sorted with $sortClauses and returns an array of Location
     *
     * @param int $parentLocationId
     * @param array $typeIdentifiers
     * @param array $sortClauses
     * @param int|null $limit
     * @param int $offset
     * @return \eZ\Publish\API\Repository\Values\Content\Location[]
     */
    public function locationTree(
        $parentLocationId, array $typeIdentifiers = array(),
        array $sortClauses = array(), $limit = null, $offset = 0
    )
    {
        $search = $this->searchTree(
            $parentLocationId, $typeIdentifiers,
            $sortClauses, $limit, $offset
        );
        $locationService = $this->repository->getLocationService();
        $results = array();
        foreach ( $search->searchHits as $hit )
        {
            $results[] = $locationService->loadLocation(
                $hit->valueObject->contentInfo->mainLocationId
            );
        }
        return $results;
    }


    /**
     * Searches for content under $parentLocationId being of the specified
     * types sorted with $sortClauses and returns an array of Content.
     *
     * @param int $parentLocationId
     * @param array $typeIdentifiers
     * @param array $sortClauses
     * @param int|null $limit
     * @param int $offset
     * @return \eZ\Publish\API\Repository\Values\Content\Content[]
     */
    public function contentList(
        $parentLocationId, array $typeIdentifiers = array(),
        array $sortClauses = array(), $limit = null, $offset = 0
    )
    {
        $search = $this->searchList(
            $parentLocationId, $typeIdentifiers,
            $sortClauses, $limit, $offset
        );
        $results = array();
        foreach ( $search->searchHits as $hit )
        {
            $results[] = $hit->valueObject;
        }
        return $results;
    }

    /**
     * Searches for content under $parentLocationId at any level being of the
     * specified types sorted with $sortClauses and returns an array of Content
     *
     * @param int $parentLocationId
     * @param array $typeIdentifiers
     * @param array $sortClauses
     * @param int|null $limit
     * @param int $offset
     * @return \eZ\Publish\API\Repository\Values\Content\Content[]
     */
    public function contentTree(
        $parentLocationId, array $typeIdentifiers = array(),
        array $sortClauses = array(), $limit = null, $offset = 0
    )
    {
        $search = $this->searchTree(
            $parentLocationId, $typeIdentifiers,
            $sortClauses, $limit, $offset
        );
        $results = array();
        foreach ( $search->searchHits as $hit )
        {
            $results[] = $hit->valueObject;
        }
        return $results;
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
    public function searchList(
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
    public function searchTree(
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


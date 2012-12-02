<?php

namespace Planet\PlanetBundle\Import;

use \InvalidArgumentException,
    eZ\Publish\API\Repository\UserService,
    eZ\Publish\API\Repository\ContentTypeService;

/**
 * Contains general informations on the post import process. For now, it
 * contains:
 * - the id of the user that will own the content
 * - the content type identifier of the object to be created/updated
 * - the parent location id under which the content will be placed.
 */
class PostImportStruct
{
    /**
     * The user id
     *
     * @var int
     */
    protected $userId;

    /**
     * The content type identifier
     *
     * @var string
     */
    protected $contentTypeIdentifier;

    /**
     * The parent location id of the post object
     *
     * @var int
     */
    protected $parentLocationId;

    /**
     * Mapping between Post properties and type fields
     *
     * @var array
     */
    protected $mapping;


    /**
     * Builds the PostImportStruct
     *
     * @param int $user
     * @param string $contentType
     * @param int $parentLocation
     * @param array $mapping
     */
    public function __construct(
        $userId, $contentTypeIdentifier, $parentLocationId, array $mapping
    )
    {
        if ( !is_numeric( $userId ) )
        {
            throw new InvalidArgumentException(
                "userId parameter should be an int, input: {$userId}"
            );
        }
        if ( !is_numeric( $parentLocationId ) )
        {
            throw new InvalidArgumentException(
                "parentLocationId parameter should be an int, input: {$parentLocationId}"
            );
        }
        if ( !is_string( $contentTypeIdentifier ) )
        {
            throw new InvalidArgumentException(
                "contentTypeIdentifier parameter should be a string, input: {$contentTypeIdentifier}"
            );
        }
        $this->userId = (int)$userId;
        $this->contentTypeIdentifier = (string)$contentTypeIdentifier;
        $this->parentLocationId = (int)$parentLocationId;
        $this->mapping = $mapping;
    }

    /**
     * Returns the user id
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Returns the content type identifier
     *
     * @return string
     */
    public function getContentTypeIdentifier()
    {
        return $this->contentTypeIdentifier;
    }

    /**
     * Returns the parent location id
     *
     * @return int
     */
    public function getParentLocationId()
    {
        return $this->parentLocationId;
    }

    /**
     * Returns the mapping between Post properties and type fields.
     *
     * @return array
     */
    public function getMapping()
    {
        return $this->mapping;
    }

    /**
     * Returns the user whose id is referenced in the struct
     *
     * @param eZ\Publish\API\Repository\UserService $userService 
     * @return eZ\Publish\API\Repository\Values\User\User
     */
    public function getUser( UserService $userService )
    {
        return $userService->loadUser( $this->userId );
    }

    /**
     * Returns the content type which identifier is referenced in the struct
     *
     * @param eZ\Publish\API\Repository\ContentTypeService $typeService
     * @return eZ\Publish\API\Repository\Values\ContentType\ContentType
     */
    public function getContentType( ContentTypeService $typeService )
    {
        return $typeService->loadContentTypeByIdentifier(
            $this->contentTypeIdentifier
        );
    }


}


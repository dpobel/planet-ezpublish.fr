<?php

namespace Planet\PlanetBundle\Import;

use Planet\PlanetBundle\Import\Parser as ParserInterface,
    Planet\PlanetBundle\Import\PostImportStruct,
    Planet\PlanetBundle\Import\Post,
    Planet\PlanetBundle\Import\ImportResultStruct,

    eZ\Publish\Core\Base\Exceptions\NotFoundException,
    eZ\Publish\Core\MVC\ConfigResolverInterface,

    eZ\Publish\API\Repository\Repository,
    eZ\Publish\API\Repository\Values\Content\Content,

    InvalidArgumentException;

class Importer
{
    /**
     * The repository
     *
     * @var eZ\Publish\API\Repository\Repository
     */
    protected $repository;

    /**
     * The configuration resolver
     *
     * @var eZ\Publish\Core\MVC\ConfigResolverInterface
     */
    protected $configResolver;

    const REMOTE_ID_SUFFIX = '_Planete_RSSImport';

    public function __construct( Repository $repository, ConfigResolverInterface $config )
    {
        $this->repository = $repository;
        $this->configResolver = $config;
    }

    /**
     * Imports the posts found by $parser and returns the result as an
     * ImportResultStruct object.
     *
     * @param Planet\PlanetBundle\Import\PostImportStruct $postInfo
     * @param Planet\PlanetBundle\Import\Parser $parser
     * @return Planet\PlanetBundle\Import\ImportResultStruct
     */
    public function import( PostImportStruct $postInfo, ParserInterface $parser )
    {
        $this->repository->setCurrentUser(
            $postInfo->getUser(
                $this->repository->getUserService()
            )
        );
        $contentService = $this->repository->getContentService();

        $result = new ImportResultStruct();
        $posts = $parser->parse();
        foreach ( $posts as $post )
        {
            try
            {
                $content = $contentService->loadContentByRemoteId(
                    $this->buildContentRemoteId(
                        $post,
                        $postInfo->getParentLocationId()
                    )
                );
                if ( $this->needUpdate( $content, $post ) )
                {
                    $result->addUpdated(
                        $this->updatePost( $content, $postInfo, $post )
                    );
                }
                else
                {
                    $result->addUnchanged( $content );
                }
            }
            catch( NotFoundException $e )
            {
                $result->addCreated(
                    $this->createPost( $postInfo, $post )
                );
            }
        }
        return $result;
    }

    /**
     * Checks whether the $content needs to be updated
     *
     * @param eZ\Publish\API\Repository\Values\Content\Content $content
     * @param Planet\PlanetBundle\Import\Post $post
     * @return bool
     */
    protected function needUpdate( Content $content, Post $post )
    {
        return (
            $content->getField( 'title' )->value->text !== $post->title
            || $content->getField( 'html' )->value->text !== $post->text
            || $content->getField( 'url' )->value->link !== $post->url
        );
    }

    /**
     * Update $content with data provided by $postInfo and $post
     *
     * @param eZ\Publish\API\Repository\Values\Content\Content $content
     * @param Planet\PlanetBundle\Import\PostImportStruct $postInfo
     * @param Planet\PlanetBundle\Import\Post $post
     * @return eZ\Publish\API\Repository\Values\Content\Content
     */
    protected function updatePost( Content $content, PostImportStruct $postInfo, Post $post )
    {
        $contentService = $this->repository->getContentService();

        $contentDraft = $contentService->createContentDraft(
            $content->contentInfo
        );
        $contentStruct = $contentService->newContentUpdateStruct();
        foreach ( $postInfo->getMapping() as $prop => $field )
        {
            $contentStruct->setField( $field, $post->{$prop} );
        }

        $contentDraft = $contentService->updateContent(
            $contentDraft->versionInfo,
            $contentStruct
        );
        return $contentService->publishVersion( $contentDraft->versionInfo );
    }


    /**
     * Create a post using data provided by $postInfo and $post
     *
     * @param Planet\PlanetBundle\Import\PostImportStruct $postInfo
     * @param Planet\PlanetBundle\Import\Post $post
     * @return eZ\Publish\API\Repository\Values\Content\Content
     */
    protected function createPost( PostImportStruct $postInfo, Post $post )
    {
        $contentService = $this->repository->getContentService();
        $locationService = $this->repository->getLocationService();

        $contentType = $postInfo->getContentType(
            $this->repository->getContentTypeService()
        );

        $locationStruct = $locationService->newLocationCreateStruct(
            $postInfo->getParentLocationId()
        );
        $contentStruct = $contentService->newContentCreateStruct(
            $contentType,
            $this->getLanguageCode()
        );
        $contentStruct->remoteId = $this->buildContentRemoteId(
            $post, $postInfo->getParentLocationId()
        );
        
        foreach ( $postInfo->getMapping() as $prop => $field )
        {
            $contentStruct->setField( $field, $post->{$prop} );
        }

        $draft = $contentService->createContent(
            $contentStruct,
            array( $locationStruct )
        );
        return $contentService->publishVersion(
            $draft->versionInfo
        );
    }

    /**
     * Returns the remote id of the content associated with $post
     *
     * @param Planet\PlanetBundle\Import\Post $post
     * @param string $parentLocationId
     * @return string
     */
    protected function buildContentRemoteId( Post $post, $parentLocationId )
    {
        return md5( $post->id )
            . '_' . $parentLocationId
            . self::REMOTE_ID_SUFFIX;
    }

    /**
     * Returns the language code to use while creating content
     *
     * @return string
     */
    protected function getLanguageCode()
    {
        $languages = $this->configResolver->getParameter( 'languages' );
        return $languages[0];
    }

}

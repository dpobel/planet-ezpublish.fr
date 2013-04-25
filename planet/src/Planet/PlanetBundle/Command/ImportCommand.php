<?php

namespace Planet\PlanetBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use eZ\Publish\API\Repository\Values\Content\Content;
use Planet\PlanetBundle\Import\Parser\Feed;
use Planet\PlanetBundle\Import\Parser\Exception\NotFound as FeedNotFound;
use Planet\PlanetBundle\Import\Parser\Exception\Invalid as InvalidFeed;
use Planet\PlanetBundle\Import\PostImportStruct;
use DateTime;

class ImportCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this->setName( 'planet:import-feeds' );
    }

    protected function execute( InputInterface $input, OutputInterface $output )
    {
        $container = $this->getContainer();
        $configResolver = $container->get( 'ezpublish.config.resolver' );

        $languages = $configResolver->getParameter( 'languages' );

        $importer = $container->get( 'planet.importer' );

        $sites = $this->getSiteList();
        foreach ( $sites as $site )
        {
            $output->write(
                "Importing {$site->getField( 'rss' )->value->link}"
            );
            try
            {
                $results = $importer->import(
                    new PostImportStruct(
                        $container->getParameter( 'planet.import.user_id' ),
                        $container->getParameter( 'planet.import.type_identifier' ),
                        $site->contentInfo->mainLocationId,
                        $languages[0],
                        $container->getParameter( 'planet.import.mapping' )
                    ),
                    new Feed( $site->getField( 'rss' )->value->link )
                );
                $created = $results->getCreated();
                if ( !empty( $created ) )
                {
                    $this->touchSite( $site );
                }
            }
            catch ( FeedNotFound $e )
            {
                $output->writeLn( ' KO (feed not found)' );
                continue;
            }
            catch( InvalidFeed $e )
            {
                $output->writeLn( ' KO (invalid feed)' );
                continue;
            }
            $output->writeLn( ' OK' );
        }

    }

    /**
     * Update the modification_date field of the $site with the current
     * datetime.
     *
     * @param eZ\Publish\API\Repository\Values\Content\Content $site 
     * @return eZ\Publish\API\Repository\Values\Content\Content
     */
    protected function touchSite( Content $site )
    {
        $contentService = $this->getContainer()
            ->get( 'ezpublish.api.repository' )
            ->getContentService();

        $contentDraft = $contentService->createContentDraft(
            $site->contentInfo
        );
        $contentStruct = $contentService->newContentUpdateStruct();
        $contentStruct->setField( 'modification_date', new DateTime() );

        $contentDraft = $contentService->updateContent(
            $contentDraft->versionInfo,
            $contentStruct
        );
        return $contentService->publishVersion( $contentDraft->versionInfo );
    }

    protected function getSiteList()
    {
        $container = $this->getContainer();
        $repository = $container->get( 'ezpublish.api.repository' );
        $contentService = $repository->getContentService();
        $locationService = $repository->getLocationService();

        $result = $container->get( 'planet.helper.content' )->contentTree(
            $container->getParameter( 'planet.tree.root' ),
            array( 'site' )
        );

        $sites = array();
        foreach ( $result->searchHits as $hit )
        {
            $sites[] = $hit->valueObject;
        }
        return $sites;
    }
}

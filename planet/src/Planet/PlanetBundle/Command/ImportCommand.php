<?php

namespace Planet\PlanetBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Output\OutputInterface,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputOption,

    Planet\PlanetBundle\Import\Parser\Feed,
    Planet\PlanetBundle\Import\Parser\Exception\NotFound as FeedNotFound,
    Planet\PlanetBundle\Import\Parser\Exception\Invalid as InvalidFeed,
    Planet\PlanetBundle\Import\PostImportStruct;

class ImportCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this->setName( 'planet:import-feeds' );
    }

    protected function execute( InputInterface $input, OutputInterface $output )
    {
        $container = $this->getContainer();

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
                        $container->getParameter( 'planet.import.mapping' )
                    ),
                    new Feed( $site->getField( 'rss' )->value->link )
                );
            }
            catch( FeedNotFound $e )
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

    protected function getSiteList()
    {
        $container = $this->getContainer();
        $repository = $container->get( 'ezpublish.api.repository' );
        $contentService = $repository->getContentService();
        $locationService = $repository->getLocationService();

        $result = $locationService->contentTree(
            $container->getParameter( 'planet.tree.root' ),
            array( 'site' )
        );

        $sites = array();
        foreach ( $result->searchHits as $hit )
        {
            $sites[] = $contentService->loadContent(
                $hit->valueObject->id
            );
        }
        return $sites;
    }


}

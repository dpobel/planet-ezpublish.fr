<?php

namespace Planet\PlanetBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root( 'planet' );
        $rootNode
            ->children()
                ->scalarNode( 'root_location_id' )
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode( 'blogs_location_id' )
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode( 'planetarium_location_id' )
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
            ->end()
        ;


        return $treeBuilder;
    }
}

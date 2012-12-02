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
                ->arrayNode( 'tree' )
                    ->children()
                        ->scalarNode( 'root' )
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode( 'blogs' )
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode( 'planetarium' )
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode( 'page' )
                    ->children()
                        ->scalarNode( 'posts' )
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode( 'title' )
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode( 'import' )
                    ->children()
                        ->scalarNode( 'user_id' )
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode( 'type_identifier' )
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->arrayNode( 'mapping' )
                            ->isRequired()
                            ->cannotBeEmpty()
                            ->children()
                                ->scalarNode( 'title' )
                                    ->isRequired()
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode( 'text' )
                                    ->isRequired()
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode( 'url' )
                                    ->isRequired()
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode( 'publishedDate' )
                                    ->isRequired()
                                    ->cannotBeEmpty()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

            ->end()
        ;


        return $treeBuilder;
    }
}

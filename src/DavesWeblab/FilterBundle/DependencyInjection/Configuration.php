<?php

namespace DavesWeblab\FilterBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $tree = new TreeBuilder();
        $root = $tree->root("daves_weblab_filter");

        $root
            ->children()
                ->arrayNode("iterator")
                    ->addDefaultsIfNotSet()

                    ->children()
                        ->arrayNode("handlers")
                            ->scalarPrototype()
                            ->defaultValue([])
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $tree;
    }
}
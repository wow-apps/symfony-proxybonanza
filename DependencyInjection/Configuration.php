<?php

namespace Wowapps\ProxyBonanzaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('wowapps_proxybonanza');

        $rootNode
            ->children()
                ->scalarNode('api_url')->defaultValue('https://api.proxybonanza.com/v1/')->end()
                ->scalarNode('api_key')->defaultValue('')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}

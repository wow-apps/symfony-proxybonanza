<?php
/**
 * This file is part of the wow-apps/symfony-proxybonanza project
 * https://github.com/wow-apps/symfony-proxybonanza
 *
 * (c) 2016 WoW-Apps
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WowApps\ProxybonanzaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @author Alexey Samara <lion.samara@gmail.com>
 * @package wow-apps/symfony-proxybonanza
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('wow_apps_proxybonanza');

        $rootNode
            ->children()
                ->scalarNode('api_url')->defaultValue('https://api.proxybonanza.com/v1/')->end()
                ->scalarNode('api_key')->defaultValue('')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}

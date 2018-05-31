<?php

namespace Adeelnawaz\PolrApiBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('polr_api');

        $rootNode
            ->children()
                ->scalarNode('api_url')->cannotBeEmpty()->end()
                ->scalarNode('api_key')->cannotBeEmpty()->end()
                ->integerNode('api_quota')->min(0)->end()
            ->end()
        ;

        return $treeBuilder;
    }
}

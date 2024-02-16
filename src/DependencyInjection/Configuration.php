<?php

namespace Pentatrion\ViteBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('pentatrion_vite');
        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('public_directory')
                ->defaultValue('public')
                ->end()
                ->scalarNode('build_directory')
                    ->info('we only need build_directory to locate entrypoints.json file, it\'s the "base" vite config parameter without slashes.')
                    ->defaultValue('build')
                ->end()
                ->scalarNode('proxy_origin')
                    ->info('Allows to use different origin for asset proxy, eg. http://host.docker.internal:5173')
                    ->defaultValue(null)
                ->end()
                ->booleanNode('absolute_url')
                    ->info('Prepend the rendered link and script tags with an absolute URL.')
                    ->defaultValue(false)
                ->end()
                ->scalarNode('throw_on_missing_entry')
                    ->info('Throw exception when entry is not present in the entrypoints file')
                    ->defaultValue(false)
                ->end()
                ->booleanNode('cache')
                    ->info('Enable caching of the entry point file(s)')
                    ->defaultFalse()
                ->end()
                ->enumNode('preload')
                ->values(['none', 'link-tag', 'link-header'])
                ->info('preload all rendered script and link tags automatically via the http2 Link header. (symfony/web-link is required) Instead <link rel="modulepreload"> will be used.')
                ->defaultValue('link-tag')
                ->end()
                ->enumNode('crossorigin')
                    ->defaultFalse()
                    ->values([false, 'anonymous', 'use-credentials'])
                    ->info('crossorigin value, can be false (default), anonymous or use-credentials')
                ->end()
                ->arrayNode('script_attributes')
                    ->info('Key/value pair of attributes to render on all script tags')
                    ->example('{ defer: true, referrerpolicy: "origin" }')
                    ->normalizeKeys(false)
                    ->scalarPrototype()
                    ->end()
                ->end()
                ->arrayNode('link_attributes')
                    ->info('Key/value pair of attributes to render on all stylesheet link tags')
                    ->example('{ referrerpolicy: "origin" }')
                    ->normalizeKeys(false)
                    ->scalarPrototype()
                    ->end()
                ->end()
                ->arrayNode('preload_attributes')
                    ->info('Key/value pair of attributes to render on all modulepreload link tags')
                    ->example('{ referrerpolicy: "origin" }')
                    ->normalizeKeys(false)
                    ->scalarPrototype()
                    ->end()
                ->end()
                ->scalarNode('default_build')
                    ->defaultValue(null)
                    ->setDeprecated('pentatrion/vite-bundle', '6.0.0', 'The "%node%" option is deprecated. Use "default_config" instead.')
                ->end()
                ->arrayNode('builds')
                    ->setDeprecated('pentatrion/vite-bundle', '6.0.0', 'The "%node%" option is deprecated. Use "configs" instead.')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('build_directory')
                                ->defaultValue('build')
                            ->end()
                            ->arrayNode('script_attributes')
                                ->info('Key/value pair of attributes to render on all script tags')
                                ->example('{ defer: true, referrerpolicy: "origin" }')
                                ->normalizeKeys(false)
                                ->scalarPrototype()
                                ->end()
                            ->end()
                            ->arrayNode('link_attributes')
                                ->info('Key/value pair of attributes to render on all CSS link tags')
                                ->example('{ referrerpolicy: "origin" }')
                                ->normalizeKeys(false)
                                ->scalarPrototype()
                                ->end()
                            ->end()
                            ->arrayNode('preload_attributes')
                                ->info('Key/value pair of attributes to render on all modulepreload link tags')
                                ->example('{ referrerpolicy: "origin" }')
                                ->normalizeKeys(false)
                                ->scalarPrototype()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('default_config')
                    ->defaultValue(null)
                ->end()
                ->arrayNode('configs')
                    ->useAttributeAsKey('name')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('build_directory')
                                ->defaultValue('build')
                            ->end()
                            ->arrayNode('script_attributes')
                                ->info('Key/value pair of attributes to render on all script tags')
                                ->example('{ defer: true, referrerpolicy: "origin" }')
                                ->normalizeKeys(false)
                                ->scalarPrototype()
                                ->end()
                            ->end()
                            ->arrayNode('link_attributes')
                                ->info('Key/value pair of attributes to render on all CSS link tags')
                                ->example('{ referrerpolicy: "origin" }')
                                ->normalizeKeys(false)
                                ->scalarPrototype()
                                ->end()
                            ->end()
                            ->arrayNode('preload_attributes')
                                ->info('Key/value pair of attributes to render on all modulepreload link tags')
                                ->example('{ referrerpolicy: "origin" }')
                                ->normalizeKeys(false)
                                ->scalarPrototype()
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

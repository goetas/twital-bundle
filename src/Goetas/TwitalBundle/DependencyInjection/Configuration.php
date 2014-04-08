<?php

namespace Goetas\TwitalBundle\DependencyInjection;

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
        $builder = new TreeBuilder();

        $builder->root('twital')
            // filters
            ->fixXmlConfig('source_adapter')
            ->children()
                ->arrayNode('source_adapters')
                    ->defaultValue(array(
                    	'twital.source_adapter.xml'=>array('/\.xml\.twital$/'),
                        'twital.source_adapter.html5'=>array('/\.html\.twital$/'),
                        'twital.source_adapter.xhtml'=>array('/\.xhtml\.twital$/'),
                    ))
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->prototype('variable')
                        ->treatNullLike(array())
                        ->validate()
                            ->ifTrue(function($v) { return !is_array($v); })
                            ->thenInvalid('The twital.source_adapters config %s must be either null or an array.')
                        ->end()
                    ->end()
                    ->validate()
                        ->always(function($v) {
                            return $v;
                        })
                    ->end()
                ->end()
            ->end()

        ;

        return $builder;
    }
}

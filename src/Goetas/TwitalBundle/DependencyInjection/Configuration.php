<?php

namespace Goetas\TwitalBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 *
 * @author Asmir Mustafic <goetas@gmail.com>
 *
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
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('service')
                    ->defaultValue(array(
                   	    array('service'=>'twital.source_adapter.xml', 'pattern' => array('/\.xml\.twital$/')),
                        array('service'=>'twital.source_adapter.html5', 'pattern' => array('/\.html\.twital$/')),
                        array('service'=>'twital.source_adapter.xhtml', 'pattern' => array('/\.xhtml\.twital$/')),
                    ))
                    ->prototype('array')
                        ->children()
                            ->arrayNode('pattern')
                                ->isRequired()
                                ->requiresAtLeastOneElement()
                                    ->prototype('scalar')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()

        ;

        return $builder;
    }
}

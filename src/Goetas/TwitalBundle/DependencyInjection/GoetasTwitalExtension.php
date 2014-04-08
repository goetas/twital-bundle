<?php

namespace Goetas\TwitalBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Definition;

use Goetas\TwitalBundle\Assetic\DirectoryResourceDefinition;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class GoetasTwitalExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('twital.xml');


        $loaderDefinition = $container->getDefinition("twital.loader");
        foreach($config["source_adapters"] as $id => $regs){
            foreach($regs as $reg){
                $loaderDefinition->addMethodCall('addSourceAdapter', array($reg, new Reference($id)));
            }
        }

        $bundles = $container->getParameter("kernel.bundles");
        if (isset($bundles["AsseticBundle"])){
            $loader->load('assetic.xml');
        }

        if (isset($bundles["JMSTranslationBundle"])){
            $loader->load('jms-translation-bundle.xml');
        }
    }
}

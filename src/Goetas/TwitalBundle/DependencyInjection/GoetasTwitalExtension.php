<?php

namespace Goetas\TwitalBundle\DependencyInjection;

use Goetas\TwitalBundle\Assetic\DirectoryResourceDefinition;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 *
 * @author Asmir Mustafic <goetas@gmail.com>
 *
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

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('twital.xml');


        $loaderDefinition = $container->getDefinition("twital.loader");
        foreach ($config["source_adapters"] as $id => $regs) {
            foreach ($regs["pattern"] as $reg) {
                $loaderDefinition->addMethodCall('addSourceAdapter', array($reg, new Reference($id)));
            }
        }

        $bundles = $container->getParameter("kernel.bundles");
        if (isset($bundles["AsseticBundle"])) {
            $loader->load('assetic.xml');
        }

        if (!empty($config["full_twig_compatibility"])) {
            $twitalDefinitioin = $container->getDefinition("twital");
            $twitalDefinitioin->addMethodCall('addExtension', array(new Reference('twital.extension.full_twig_compatibility')));
        }

        if (!class_exists('Symfony\Bundle\FrameworkBundle\CacheWarmer\TemplateFinderInterface')) {
            $container->removeDefinition('twital.cache_warmer');
        }

        if (!interface_exists('Symfony\Component\Templating\EngineInterface')
            || !class_exists('Symfony\Bundle\TwigBundle\TwigEngine')) {
            $container->removeDefinition('templating.engine.twital');
        }
    }
}

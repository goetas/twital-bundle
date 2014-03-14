<?php

namespace Goetas\TwitalBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Definition;

use Goetas\TwitalBundle\Assetic\DirectoryResourceDefinition;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

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

        $bundles = $container->getParameter('kernel.bundles');

        if (0 && isset($bundles["JMSTranslationBundle"])){
        	$loader->load('jms-translation-bundle.xml');
        }
        if (0 && isset($bundles["AsseticBundle"])){
        	$loader->load('assetic.xml');
	        $engine = 'twital';
	    	// bundle resources
	        foreach ($bundles as $bundle => $bundleClass) {
	            $rc = new \ReflectionClass($bundleClass);
                $container->setDefinition(
                    'assetic.custom_'.$engine.'_directory_resource.'.$bundle,
                    new DirectoryResourceDefinition($bundle, $engine, array(
                        $container->getParameter('kernel.root_dir').'/Resources/'.$bundle.'/views',
                        dirname($rc->getFileName()).'/Resources/views',
                    ))
                );
	        }

	        // kernel resources
            $container->setDefinition(
                'assetic.custom_'.$engine.'_directory_resource.kernel',
                new DirectoryResourceDefinition('', $engine, array($container->getParameter('kernel.root_dir').'/Resources/views'))
            );

        }
    }
}

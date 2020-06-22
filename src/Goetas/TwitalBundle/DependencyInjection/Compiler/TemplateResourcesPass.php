<?php

namespace Goetas\TwitalBundle\DependencyInjection\Compiler;

use Goetas\TwitalBundle\DependencyInjection\DirectoryResourceDefinition;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TemplateResourcesPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('assetic.asset_manager')) {
            return;
        }

        foreach ($container->getParameter('twital.loader_regexs') as $regex) {
            $this->setAppDirectoryResources($container, $regex);
        }
    }

    protected function setAppDirectoryResources(ContainerBuilder $container, $regex)
    {
        $dirs = array(
            $container->getParameter('kernel.root_dir') . '/Resources/views',
        );
        if ($container->hasParameter('kernel.project_dir')) {
            $dirs[] = $container->getParameter('kernel.project_dir') . '/templates';
        }
        $container->setDefinition(
            'assetic.' . md5($regex) . '_twital_directory_resource.kernel',
            new DirectoryResourceDefinition('', 'twital', $regex, $dirs)
        );
    }
}

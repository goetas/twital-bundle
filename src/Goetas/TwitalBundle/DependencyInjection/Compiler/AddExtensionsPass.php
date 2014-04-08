<?php
namespace Goetas\TwitalBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AddExtensionsPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        if (false === $container->hasDefinition('twital')) {
            return;
        }

        $twitalDefinition = $container->getDefinition("twital");
        $extensionsIds = $container->findTaggedServiceIds("twital.extension");
        foreach ($extensionsIds as $extensionId => $params) {
            $twitalDefinition->addMethodCall('addExtension', array(
                new Reference($extensionId)
            ));
        }
    }
}
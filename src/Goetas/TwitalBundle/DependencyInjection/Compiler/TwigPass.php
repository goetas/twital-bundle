<?php

namespace Goetas\TwitalBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 *
 * @author Martin Hasoň <martin.hason@gmail.com>
 *
 */
class TwigPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $twitalLoader = $container->getDefinition('twital.loader');
        $twitalLoader->replaceArgument(0, $container->findDefinition('twig.loader'));
        $container->setDefinition('twig.loader', $twitalLoader);
    }
}


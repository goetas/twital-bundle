<?php

namespace Goetas\TwitalBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 *
 * @author Martin Hasoň <martin.hason@gmail.com>
 *
 */
class TemplatingPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('templating.engine.twig')) {
            $container->removeDefinition('templating.engine.twital');
        }
    }
}


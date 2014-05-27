<?php
namespace Goetas\TwitalBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Goetas\TwitalBundle\DependencyInjection\Compiler\AddExtensionsPass;
use Goetas\TwitalBundle\DependencyInjection\Compiler\TwigPass;

/**
 *
 * @author Asmir Mustafic <goetas@gmail.com>
 *
 */
class GoetasTwitalBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new AddExtensionsPass());
        $container->addCompilerPass(new TwigPass());
    }
}

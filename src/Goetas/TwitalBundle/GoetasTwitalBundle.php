<?php

namespace Goetas\TwitalBundle;

use Goetas\TwitalBundle\DependencyInjection\Compiler\AddExtensionsPass;
use Goetas\TwitalBundle\DependencyInjection\Compiler\JMSTranslationBundlePass;
use Goetas\TwitalBundle\DependencyInjection\Compiler\TemplateResourcesPass;
use Goetas\TwitalBundle\DependencyInjection\Compiler\TemplatingPass;
use Goetas\TwitalBundle\DependencyInjection\Compiler\TwigPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

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
        $container->addCompilerPass(new TemplatingPass());
        $container->addCompilerPass(new TemplateResourcesPass());
        $container->addCompilerPass(new JMSTranslationBundlePass());
    }
}

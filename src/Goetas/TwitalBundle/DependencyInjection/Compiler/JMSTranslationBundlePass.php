<?php

namespace Goetas\TwitalBundle\DependencyInjection\Compiler;

use Goetas\TwitalBundle\Translation\Jms\TwitalExtractor;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 *
 * @author Asmir Mustafic <goetas@gmail.com>
 *
 */
class JMSTranslationBundlePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if ($container->hasDefinition('jms_translation.extractor.file.twig_extractor')) {
            $container->register('twital.translation.extractor.jms', TwitalExtractor::class)
                ->setDecoratedService('jms_translation.extractor.file.twig_extractor', 'jms_translation.extractor.file.twig_extractor.inner')
                ->setArguments(array(
                    new Reference('twig'),
                    new Reference('twital.loader'),
                    new Reference('jms_translation.extractor.file.twig_extractor.inner'),
                ));
        }
    }
}


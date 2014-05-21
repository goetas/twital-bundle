<?php

namespace Goetas\TwitalBundle\Engine;

use Symfony\Component\DependencyInjection\Container;


use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Bundle\FrameworkBundle\Templating\GlobalVariables;
use Symfony\Component\Templating\TemplateNameParserInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Bundle\TwigBundle\TwigEngine;
use Goetas\Twital\TwitalLoader;
use Symfony\Component\Config\FileLocatorInterface;

/**
 *
 * @author Asmir Mustafic <goetas@gmail.com>
 *
 */
class TwitalEngine extends TwigEngine
{

    /**
     * Constructor.
     *
     * @param \Twig_Environment           $environment A \Twig_Environment instance
     * @param TemplateNameParserInterface $parser      A TemplateNameParserInterface instance
     * @param FileLocatorInterface        $locator     A FileLocatorInterface instance
     */
    public function __construct(\Twig_Environment $environment, TwitalLoader $twitalLoader, TemplateNameParserInterface $parser, FileLocatorInterface $locator)
    {
        parent::__construct($environment, $parser, $locator);

        $twitalLoader->setLoader($environment->getLoader());
        $environment->setLoader($twitalLoader);
    }
    /**
     * Returns true if this class is able to render the given template.
     *
     * @param string $name A template name
     *
     * @return Boolean True if this class supports the given resource, false otherwise
     */
    public function supports($name)
    {
        if ($name instanceof \Twig_Template) {
            return true;
        }
        $template = $this->parser->parse($name);
        return 'twital' === $template->get('engine');
    }
}
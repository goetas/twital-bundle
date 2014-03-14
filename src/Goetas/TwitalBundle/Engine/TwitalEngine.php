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

class TwitalEngine extends TwigEngine
{
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
    public function hookIntoTwig(TwitalLoader $twitalLoader)
    {
        $twitalLoader->setLoader($this->environment->getLoader());
        $this->environment->setLoader($twitalLoader);
    }
}
<?php

namespace Goetas\TwitalBundle\Engine;

use Goetas\TwitalBundle\Helper\TwitalHelper;

use goetas\twital\Compiler;

use Goetas\TwitalBundle\Locale\Translator;

use Goetas\TwitalBundle\TwitalBundle;

use Symfony\Component\DependencyInjection\Container;

use goetas\twital\BasePhpModifier;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Bundle\FrameworkBundle\Templating\GlobalVariables;
use Symfony\Component\Templating\TemplateNameParserInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;

use goetas\twital\Twital;
use goetas\twital\IFinder;
use Symfony\Bundle\TwigBundle\TwigEngine;

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
}
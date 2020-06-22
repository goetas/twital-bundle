<?php

namespace Goetas\TwitalBundle\Engine;

use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Templating\TemplateNameParserInterface;

/**
 *
 * @author Asmir Mustafic <goetas@gmail.com>
 * @author Martin Hasoň <martin.hason@gmail.com>
 *
 */
class TwitalEngine implements EngineInterface
{
    private $twigEngine;
    private $parser;

    public function __construct(TwigEngine $twigEngine, TemplateNameParserInterface $parser)
    {
        $this->twigEngine = $twigEngine;
        $this->parser = $parser;
    }

    public function render($name, array $parameters = array())
    {
        return $this->twigEngine->render($name, $parameters);
    }

    public function exists($name)
    {
        return $this->twigEngine->exists($name);
    }

    public function supports($name)
    {
        $template = $this->parser->parse($name);

        return 'twital' === $template->get('engine');
    }

    public function renderResponse($view, array $parameters = array(), Response $response = null)
    {
        return $this->twigEngine->renderResponse($view, $parameters, $response);
    }
}

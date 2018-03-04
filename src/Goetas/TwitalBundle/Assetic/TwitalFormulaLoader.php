<?php

namespace Goetas\TwitalBundle\Assetic;

use Assetic\Extension\Twig\TwigFormulaLoader;
use Assetic\Factory\Resource\ResourceInterface;
use Goetas\Twital\TwitalLoader;
use Goetas\TwitalBundle\Assetic\Resource\TwitalResource;

/**
 *
 * @author Asmir Mustafic <goetas@gmail.com>
 *
 */
class TwitalFormulaLoader extends TwigFormulaLoader
{

    private $twital;

    public function __construct(TwitalLoader $twital, \Twig_Environment $twig)
    {
        $this->twital = $twital;
        parent::__construct($twig);
    }

    public function load(ResourceInterface $resource)
    {
        return parent::load(new TwitalResource($this->twital, $resource));
    }
}

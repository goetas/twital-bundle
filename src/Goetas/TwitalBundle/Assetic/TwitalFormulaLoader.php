<?php

namespace Goetas\TwitalBundle\Assetic;

use Assetic\Extension\Twig\TwigFormulaLoader;
use Assetic\Factory\Resource\ResourceInterface;
use Goetas\Twital\TwitalLoader;
use Goetas\TwitalBundle\Assetic\Resource\TwitalResource;
use Twig\Environment;

/**
 *
 * @author Asmir Mustafic <goetas@gmail.com>
 *
 */
class TwitalFormulaLoader extends TwigFormulaLoader
{

    private $twital;

    public function __construct(TwitalLoader $twital, Environment $twig)
    {
        $this->twital = $twital;
        parent::__construct($twig);
    }

    public function load(ResourceInterface $resource)
    {
        return parent::load(new TwitalResource($this->twital, $resource));
    }
}

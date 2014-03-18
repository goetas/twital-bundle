<?php
namespace Goetas\TwitalBundle\Assetic;

use Assetic\Factory\Resource\ResourceInterface;
use Assetic\Extension\Twig\TwigFormulaLoader;
use Goetas\Twital\Twital;
use Goetas\Twital\TwitalLoader;
use Goetas\TwitalBundle\Assetic\Resource\TwitalResource;

class TwitalFormulaLoader extends TwigFormulaLoader
{

    private $twital;

    public function __construct(TwitalLoader $twital,\Twig_Environment $twig)
    {
        $this->twital = $twital;
        parent::__construct($twig);
    }

    public function load(ResourceInterface $resource)
    {
        return parent::load(new TwitalResource($this->twital, $resource));
    }
}

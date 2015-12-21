<?php
namespace Goetas\TwitalBundle\Tests\Assetic;

use Goetas\TwitalBundle\Assetic\TwitalFormulaLoader;
use Goetas\Twital\Twital;
use Goetas\Twital\TwitalLoader;
use Goetas\TwitalBundle\Assetic\Resource\TwitalResource;

class TwigFormulaLoaderTest extends \PHPUnit_Framework_TestCase
{

    private $twig;

    private $twitalLoader;

    protected function setUp()
    {
        $this->twitalLoader = new TwitalLoader();
        $this->twig = new \Twig_Environment($this->twitalLoader);
    }

    public function testMixture()
    {
        $twitalLoader = $this->getMock('Goetas\Twital\TwitalLoader');

        $loader = new TwitalFormulaLoader($twitalLoader, $this->twig);

        $resource = $this->getMock('Assetic\\Factory\\Resource\\ResourceInterface');
        /*
        $resource->expects($this->once())
            ->method('__toString')
            ->will($this->returnValue('aaa.html.twital'));
        */
        $resource->expects($this->once())
            ->method('getContent')
            ->will($this->returnValue('<div/>'));

        $loader->load($resource);
    }
}

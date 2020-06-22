<?php
namespace Goetas\TwitalBundle\Tests\Assetic;

use Assetic\Factory\Resource\ResourceInterface;
use Goetas\Twital\TwitalLoader;
use Goetas\TwitalBundle\Assetic\TwitalFormulaLoader;
use Goetas\TwitalBundle\Tests\TestCase;
use Twig\Environment;

class TwigFormulaLoaderTest extends TestCase
{
    private $twig;

    private $twitalLoader;

    protected function setUp()
    {
        if (!class_exists('Assetic\Extension\Twig\TwigFormulaLoader') || !class_exists(Environment::class)) {
            $this->markTestSkipped();
        }

        $this->twitalLoader = new TwitalLoader();
        $this->twig = new Environment($this->twitalLoader);
    }

    public function testMixture()
    {
        $twitalLoader = $this->createMock(TwitalLoader::class);

        $loader = new TwitalFormulaLoader($twitalLoader, $this->twig);

        $resource = $this->createMock(ResourceInterface::class);
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

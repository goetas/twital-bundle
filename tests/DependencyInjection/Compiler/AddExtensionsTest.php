<?php
namespace Goetas\TwitalBundle\Tests\DependencyInjection\Compiler;

use Goetas\TwitalBundle\DependencyInjection\Compiler\AddExtensionsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 *
 * @author Asmir Mustafic <goetas@gmail.com>
 */
class AddExtensionsTest extends \PHPUnit_Framework_TestCase
{

    public function testAdd()
    {
        $twital = new Definition();

        $twitalExt = new Definition();
        $twitalExt->addTag('twital.extension');

        $container = new ContainerBuilder();
        $container->setDefinition('twital', $twital);
        $container->setDefinition('twital_ext', $twitalExt);

        $pass = new AddExtensionsPass();
        $pass->process($container);

        $calls = $twital->getMethodCalls();
        $this->assertEquals(1, count($calls));

        foreach ($calls as $call) {
            $this->assertEquals('addExtension', $call[0]);
            $this->assertEquals('twital_ext', $call[1][0]);
        }
    }
}

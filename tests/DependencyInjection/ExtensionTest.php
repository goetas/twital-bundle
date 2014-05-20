<?php
namespace Goetas\TwitalBundle\Tests\DependencyInjection;

use Goetas\TwitalBundle\DependencyInjection\GoetasTwitalExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Parser;
/**
 *
 * @author Asmir Mustafic <goetas@gmail.com>
 */
class ExtensionTest extends \PHPUnit_Framework_TestCase
{

    public function testLoad()
    {
        $loader = new GoetasTwitalExtension();
        $container = new ContainerBuilder();
        $container->setParameter('kernel.bundles',array());
        $loader->load($this->getFullConfig(), $container);

        $this->assertTrue($container->hasDefinition('templating.engine.twital'));
        $this->assertTrue($container->hasDefinition('twital'));
        $this->assertTrue($container->hasDefinition('twital.loader'));

        $this->assertTrue($container->hasDefinition('twital.source_adapter.xml'));
    }

    public function testLoadWithAssetic()
    {
        $loader = new GoetasTwitalExtension();
        $container = new ContainerBuilder();
        $container->setParameter('kernel.bundles',array('AsseticBundle'=>'AsseticBundle'));
        $loader->load($this->getFullConfig(), $container);

        $this->assertTrue($container->hasDefinition('assetic.twital_formula_loader'));
        $this->assertTrue($container->hasDefinition('assetic.twital_formula_loader.real'));
    }

    public function testLoadWithJMS()
    {
        $loader = new GoetasTwitalExtension();
        $container = new ContainerBuilder();
        $container->setParameter('kernel.bundles',array('JMSTranslationBundle'=>'JMSTranslationBundle'));
        $loader->load($this->getFullConfig(), $container);

        $this->assertTrue($container->hasDefinition('twital.translation.extractor.jms'));
    }

    protected function getFullConfig()
    {
        $parser = new Parser();
        $yaml = <<<EOF
goetas_twital:
    source_adapter:
        - { service: twital.source_adapter.xml, pattern: ['/\.xml\.twital$/', '/\.atom\.twital$/'] }
EOF;

        return $parser->parse($yaml);
    }
}

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
        $container->setParameter('kernel.bundles', array());
        $loader->load($this->getFullConfig(), $container);

        $this->assertTrue($container->hasDefinition('templating.engine.twital'));
        $this->assertTrue($container->hasDefinition('twital'));
        $this->assertTrue($container->hasDefinition('twital.loader'));

        $this->assertTrue($container->hasDefinition('twital.source_adapter.xml'), "XML Adpater");
        $this->assertTrue($container->hasDefinition('twital.source_adapter.html5'), "HTML5 Adpater");
        $this->assertTrue($container->hasDefinition('twital.source_adapter.xhtml'), "XHTML Adapter");
    }

    public function testSourceAdpters()
    {
        $loader = new GoetasTwitalExtension();
        $container = new ContainerBuilder();
        $container->setParameter('kernel.bundles', array());
        $loader->load($this->getFullConfig(), $container);

        $this->assertTrue($container->hasDefinition('twital.loader'));

        $this->assertTrue($container->hasDefinition('twital.source_adapter.xml'), "XML Adpater");
        $this->assertTrue($container->hasDefinition('twital.source_adapter.html5'), "HTML5 Adpater");
        $this->assertTrue($container->hasDefinition('twital.source_adapter.xhtml'), "XHTML Adapter");

        $loader = $container->getDefinition('twital.loader');
        $calls = $loader->getMethodCalls();

        $adpaters = array();
        foreach ($calls as $call) {
            if ($call[0] == "addSourceAdapter") {
                $adpaters[$call[1][0]] = strval($call[1][1]);
            }
        }

        $this->assertEquals(array(
            '/\.xml\.twital$/' => 'twital.source_adapter.xml',
            '/\.atom\.twital$/' => 'twital.source_adapter.xml'
        ), $adpaters);
    }

    public function testLoadWithAssetic()
    {
        $loader = new GoetasTwitalExtension();
        $container = new ContainerBuilder();
        $container->setParameter('kernel.bundles', array(
            'AsseticBundle' => 'AsseticBundle'
        ));
        $loader->load($this->getFullConfig(), $container);

        $this->assertTrue($container->hasDefinition('assetic.twital_formula_loader'));
        $this->assertTrue($container->hasDefinition('assetic.twital_formula_loader.real'));
    }

    public function testLoadWithJMS()
    {
        $loader = new GoetasTwitalExtension();
        $container = new ContainerBuilder();
        $container->setParameter('kernel.bundles', array(
            'JMSTranslationBundle' => 'JMSTranslationBundle'
        ));
        $loader->load($this->getFullConfig(), $container);

        $this->assertTrue($container->hasDefinition('twital.translation.extractor.jms'));
    }

    public function testTwigFullCompat()
    {
        $loader = new GoetasTwitalExtension();
        $container = new ContainerBuilder();
        $container->setParameter('kernel.bundles', array());
        $loader->load($this->getTwigFullCompatConfig(), $container);

        $def = $container->getDefinition('twital');
        $calls = $def->getMethodCalls();
        $this->assertEquals("addExtension", $calls[0][0]);
        $this->assertEquals("twital.extension.full_twig_compatibility", (string)$calls[0][1][0]);
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

    protected function getTwigFullCompatConfig()
    {
        $parser = new Parser();
        $yaml = <<<EOF
goetas_twital:
    full_twig_compatibility: true
EOF;

        return $parser->parse($yaml);
    }
}

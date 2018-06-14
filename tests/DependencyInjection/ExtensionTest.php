<?php

namespace Goetas\TwitalBundle\Tests\DependencyInjection;

use Goetas\TwitalBundle\DependencyInjection\Compiler\JMSTranslationBundlePass;
use Goetas\TwitalBundle\DependencyInjection\Compiler\TemplatingPass;
use Goetas\TwitalBundle\DependencyInjection\GoetasTwitalExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\Yaml\Parser;

/**
 *
 * @author Asmir Mustafic <goetas@gmail.com>
 */
class ExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testLoad()
    {
        $container = $this->getContainer($this->getFullConfig());

        $this->assertTrue($container->hasDefinition('twital.loader'));
        $this->assertTrue($container->hasDefinition('twital.source_adapter.xml'), "XML Adpater");
        $this->assertTrue($container->hasDefinition('twital.source_adapter.html5'), "HTML5 Adpater");
        $this->assertTrue($container->hasDefinition('twital.source_adapter.xhtml'), "XHTML Adapter");

        $container->compile();

        $this->assertFalse($container->has('templating.engine.twital'));
        $this->assertTrue($container->has('twital'));

    }

    public function testLoadWithTemplating()
    {
        $container = $this->getContainer($this->getFullConfig(), array(), function (ContainerBuilder $container) {
            $container->setDefinition('templating.engine.twig', new Definition('foo'));
            $container->setDefinition('templating.name_parser', new Definition('bar'));
        });
        $container->compile();

        $this->assertTrue($container->has('templating.engine.twital'));
    }

    public function testLoadWithCacheWarmer()
    {
        $container = $this->getContainer($this->getFullConfig());

        $exists = class_exists('Symfony\Bundle\FrameworkBundle\CacheWarmer\TemplateFinderInterface');

        $this->assertEquals($exists, $container->hasDefinition('twital.cache_warmer'));
        $container->compile();
    }

    public function testSourceAdapters()
    {
        $container = $this->getContainer($this->getFullConfig());

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
        $container->compile();
    }

    public function testLoadWithAssetic()
    {
        $container = $this->getContainer($this->getFullConfig(), array(
            'AsseticBundle' => 'AsseticBundle'
        ));

        $this->assertTrue($container->hasDefinition('assetic.twital_formula_loader'));
        $this->assertTrue($container->hasDefinition('assetic.twital_formula_loader.real'));
        $container->compile();
    }

    public function testLoadWithJMS()
    {
        $container = $this->getContainer($this->getFullConfig(), array(
            'JMSTranslationBundle' => 'JMSTranslationBundle'
        ), function (ContainerBuilder $containerBuilder) {

            $d = new Definition('JMS\TranslationBundle\Translation\Extractor\File\TwigFileExtractor');
            $d->setPublic(true);
            $containerBuilder->setDefinition('jms_translation.extractor.file.twig_extractor', $d);

            $containerBuilder->setDefinition('twig', new Definition('Twig_Environment'));
        });
        $container->compile();

        $def = $container->getDefinition('jms_translation.extractor.file.twig_extractor');
        $this->assertSame('Goetas\TwitalBundle\Translation\Jms\TwitalExtractor', $def->getClass());
    }

    public function testTwigFullCompat()
    {
        $container = $this->getContainer($this->getTwigFullCompatConfig());

        $def = $container->getDefinition('twital');
        $calls = $def->getMethodCalls();
        $this->assertEquals("addExtension", $calls[0][0]);
        $this->assertEquals("twital.extension.full_twig_compatibility", (string)$calls[0][1][0]);
        $container->compile();
    }

    protected function getContainer(array $config, array $bundles = array(), $configurator = null)
    {
        $loader = new GoetasTwitalExtension();
        $container = new ContainerBuilder();
        $container->setParameter('kernel.bundles', $bundles);
        $container->setParameter('kernel.debug', true);
        $container->addCompilerPass(new TemplatingPass());
        $container->addCompilerPass(new JMSTranslationBundlePass());
        if (is_callable($configurator)) {
            call_user_func($configurator, $container);
        }

        $loader->load($config, $container);
        return $container;
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

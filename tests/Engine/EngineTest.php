<?php
namespace Goetas\TwitalBundle\Tests\Engine;


use Goetas\Twital\TwitalLoader;
use Goetas\TwitalBundle\Tests\TestCase;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\Templating\TemplateReference;
use Goetas\TwitalBundle\Engine\TwitalEngine;
use Goetas\Twital\SourceAdapter\XMLAdapter;
use Symfony\Component\Templating\TemplateNameParser;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

class EngineTest extends TestCase
{

    public function setUp()
    {
        if (!interface_exists(EngineInterface::class) || !class_exists(TwigEngine::class)) {
            $this->markTestSkipped();
        }
    }

    public function testExistsWithNonExistentTemplates()
    {
        $engine = $this->getTwital();

        $this->assertFalse($engine->exists('_index.html.twital'));
        $this->assertFalse($engine->exists(new TemplateReference('_index.html.twital', 'twital')));
    }

    public function testExists()
    {
        $engine = $this->getTwital();

        $this->assertTrue($engine->exists('index.html.twital'));
        $this->assertTrue($engine->exists(new TemplateReference('index.html.twital', 'twital')));
    }

    public function testSupports()
    {
        $engine = $this->getTwital();

        $this->assertTrue($engine->supports('index.html.twital'));
        $this->assertTrue($engine->supports(new TemplateReference('index.html.twital', 'twital')));

        $this->assertFalse($engine->supports('index.html.twig'));
        $this->assertFalse($engine->supports(new TemplateReference('index.html.twig', 'twig')));
    }

    public function testRender()
    {
        $engine = $this->getTwital();

        $this->assertSame('<div/>', $engine->render('index.html.twital'));
        $this->assertSame('<div/>', $engine->render(new TemplateReference('index.html.twital', 'twital')));
    }

    protected function getTwital()
    {
        $loader = new ArrayLoader(array(
            'index.html.twital' => '<div/>'
        ));

        $twitalLoader = new TwitalLoader($loader);
        $twitalLoader->addSourceAdapter('/.*\.twital/', new XMLAdapter());

        $twig = new Environment($loader);
        $parser = new TemplateNameParser();
        $locator = $this->createMock('Symfony\Component\Config\FileLocatorInterface');

        $twigEngine = new TwigEngine($twig, $parser, $locator);

        return new TwitalEngine($twigEngine, $parser);
    }
}

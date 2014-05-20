<?php
namespace Goetas\TwitalBundle\Tests\Assetic;

use Goetas\TwitalBundle\Assetic\TwitalFormulaLoader;
use Goetas\Twital\Twital;
use Goetas\Twital\TwitalLoader;
use Goetas\TwitalBundle\Assetic\Resource\TwitalResource;
use Symfony\Component\Templating\TemplateReference;
use Goetas\TwitalBundle\Engine\TwitalEngine;
use Goetas\Twital\Template;
use Goetas\Twital\SourceAdapter\XMLAdapter;
use Symfony\Component\Templating\TemplateNameParser;

class EngineTest extends \PHPUnit_Framework_TestCase
{

    public function testRightLoader()
    {
        $engine = $this->getTwital();

        $ref = new \ReflectionObject($engine);
        $prop = $ref->getProperty('environment');
        $prop->setAccessible(true);

        $this->assertInstanceOf('Goetas\Twital\TwitalLoader', $prop->getValue($engine)->getLoader());
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
        $loader = new \Twig_Loader_Array(array(
            'index.html.twital' => '<div/>'
        ));

        $twitalLoader = new TwitalLoader($loader);
        $twitalLoader->addSourceAdapter('/.*\.twital/', new XMLAdapter());

        $twig = new \Twig_Environment($loader);
        $parser = new TemplateNameParser();
        $locator = $this->getMock('Symfony\Component\Config\FileLocatorInterface');

        return new TwitalEngine($twig, $twitalLoader, $parser, $locator);
    }
}

<?php
namespace Goetas\TwitalBundle\Tests\EventSubscriber;

use Goetas\Twital\EventDispatcher\TemplateEvent;
use Goetas\Twital\Twital;
use Goetas\Twital\Template;
use Goetas\TwitalBundle\EventSubscriber\WhiteSpaceRemovalSubscriber;

class WhiteSpaceRemovalSubscriberTest extends \PHPUnit_Framework_TestCase
{
    private $twital;

    public function setUp()
    {
        $this->twital = new Twital();
    }

    public function getTranslatableCode()
    {
        return array(
            array("content\n", 'content'),
            array("\ncontent\n", 'content'),
            array("\ncon\tte\t\t\nnt", 'con te nt'),

            array("  con <b> a     </b> tent  ", "con <b>a</b> tent"),
            array("  con <b> a     </b> <i>      </i> tent  ", "con <b>a</b> <i> </i> tent"),
        );
    }

    /**
     *
     * @dataProvider getTranslatableCode
     */
    public function testWhitespaceRemoval($original, $expected)
    {
        foreach (array('t:trans=""', 't:trans-n=""') as $tag) {
            $document = new \DOMDocument('1.0', 'UTF-8');
            $document->loadXML($this->wrapHTML($original, $tag));

            $templateEvent = new TemplateEvent($this->twital, new Template($document));

            $subscriber = new WhiteSpaceRemovalSubscriber();

            $subscriber->removeWhitespace($templateEvent);

            $this->assertEquals($this->wrapHTML($expected, $tag), $document->saveXML($document->documentElement));
        }
    }

    private function wrapHTML($text, $tag)
    {
        return "<div xmlns:t=\"" . Twital::NS . "\" $tag>$text</div>";
    }
}

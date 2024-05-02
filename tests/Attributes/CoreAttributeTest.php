<?php
namespace Goetas\TwitalBundle\Tests\Attributes;

use Goetas\Twital\Twital;
use Goetas\Twital\SourceAdapter\XMLAdapter;
use Goetas\TwitalBundle\Extension\TranslateExtension;
use Goetas\TwitalBundle\Tests\TestCase;


class CoreAttributeTest extends TestCase
{
    private $twital;
    private $sourceAdapter;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->twital = new Twital();
        $this->twital->addExtension(new TranslateExtension());
        $this->sourceAdapter = new XMLAdapter();
    }

    /**
     * @dataProvider getData
     */
    public function testVisitAttribute($source, $expected)
    {
        $compiled = $this->twital->compile($this->sourceAdapter, $source);
        $this->assertEquals($expected, $compiled);
    }

    /**
     * @dataProvider getDataDynamic
     */
    public function testVisitAttributeDynamic($source, $startsWith, $endsWith)
    {
        $compiled = $this->twital->compile($this->sourceAdapter, $source);
        $mch = null;
        $this->assertTrue(preg_match('/{% set (.*?) /', $compiled, $mch) > 0);

        $compiled = str_replace($mch[1], 'XxX', $compiled);
        $this->assertStringStartsWith($startsWith.'{% for ____ak,____av in XxX', $compiled);
        $this->assertStringEndsWith($endsWith, $compiled);
    }

    public function getDataDynamic()
    {
        return array(

            //trans-attr
            array('<div class="foo" t:trans-attr="class">content</div>', '{% set XxX = XxX|default({})|merge({\'class\':[\'foo\'|trans()]}) %}<div', '>content</div>'),
            array('<div class="foo" t:trans-attr="class:[{\'%var%\':var}]">content</div>', '{% set XxX = XxX|default({})|merge({\'class\':[\'foo\'|trans({\'%var%\':var})]}) %}<div', '>content</div>'),
            array('<div class="foo" t:trans-attr="class:[{\'%var%\':var}, \'domain\']">content</div>', '{% set XxX = XxX|default({})|merge({\'class\':[\'foo\'|trans({\'%var%\':var}, \'domain\')]}) %}<div', '>content</div>'),
            //trans-attr multiple
            array('<div class="foo" alt="bar" t:trans-attr="class, alt">content</div>', '{% set XxX = XxX|default({})|merge({\'class\':[\'foo\'|trans()],\'alt\':[\'bar\'|trans()]}) %}<div', '>content</div>'),
            array('<div class="foo" alt="bar" t:trans-attr="class:[{\'%var%\':var}], alt">content</div>', '{% set XxX = XxX|default({})|merge({\'class\':[\'foo\'|trans({\'%var%\':var})],\'alt\':[\'bar\'|trans()]}) %}<div', '>content</div>'),
            array('<div class="foo" alt="bar" t:trans-attr="class:[{\'%var%\':var}, \'domain\'], alt">content</div>', '{% set XxX = XxX|default({})|merge({\'class\':[\'foo\'|trans({\'%var%\':var}, \'domain\')],\'alt\':[\'bar\'|trans()]}) %}<div', '>content</div>'),

            //trans-attr-n
            array('<div class="foo" t:trans-attr-n="class:[n]">content</div>', '{% set XxX = XxX|default({})|merge({\'class\':[\'foo\'|transchoice(n)]}) %}<div', '>content</div>'),
            array('<div class="foo" alt="bar" t:trans-attr-n="class:[n], alt:[x]">content</div>', '{% set XxX = XxX|default({})|merge({\'class\':[\'foo\'|transchoice(n)],\'alt\':[\'bar\'|transchoice(x)]}) %}<div', '>content</div>'),
            array('<div class="foo" t:trans-attr-n="class:[n, {\'%var%\':var}]">content</div>', '{% set XxX = XxX|default({})|merge({\'class\':[\'foo\'|transchoice(n, {\'%var%\':var})]}) %}<div', '>content</div>'),
            array('<div class="foo" t:trans-attr-n="class:[n, {\'%var%\':var}, \'domain\']">content</div>', '{% set XxX = XxX|default({})|merge({\'class\':[\'foo\'|transchoice(n, {\'%var%\':var}, \'domain\')]}) %}<div', '>content</div>'),

            // combined
            array('<div class="foo" alt="bar" t:trans-attr-n="class:[n]" t:trans-attr="alt">content</div>', '{% set XxX = XxX|default({})|merge({\'class\':[\'foo\'|transchoice(n)]}) %}{% set XxX = XxX|default({})|merge({\'alt\':[\'bar\'|trans()]}) %}<div', '>content</div>'),
            array('<div class="foo" alt="bar" t:trans-attr-n="class:[n]" t:trans-attr="alt" t:trans="">content</div>', '{% set XxX = XxX|default({})|merge({\'class\':[\'foo\'|transchoice(n)]}) %}{% set XxX = XxX|default({})|merge({\'alt\':[\'bar\'|trans()]}) %}<div', '>{% trans %}content{% endtrans %}</div>'),

        );
    }

    public function getData()
    {
        return array(

            array('<div t:trans="">content</div>', '<div>{% trans %}content{% endtrans %}</div>'),
            array('<div t:trans="{\'%node%\'}">content %node%</div>', '<div>{% trans with {\'%node%\'} %}content %node%{% endtrans %}</div>'),
            array('<div t:trans="{\'%node%\'}, \'domain\'">content %node%</div>', '<div>{% trans with {\'%node%\'} from \'domain\' %}content %node%{% endtrans %}</div>'),

            array('<div t:trans-n="var">content</div>', '<div>{% transchoice var with {\'%count%\':var} %}content{% endtranschoice %}</div>'),
            array('<div t:trans-n="var,{\'%node%\'}">content</div>', '<div>{% transchoice var with {\'%count%\':var}|merge({\'%node%\'}) %}content{% endtranschoice %}</div>'),
            array('<div t:trans-n="var,{\'%node%\'},\'domain\'">content</div>', '<div>{% transchoice var with {\'%count%\':var}|merge({\'%node%\'}) from \'domain\' %}content{% endtranschoice %}</div>'),

        );
    }
}



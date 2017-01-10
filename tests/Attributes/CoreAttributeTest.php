<?php
namespace Goetas\TwitalBundle\Tests\Attributes;

use Goetas\Twital\Twital;
use Goetas\Twital\SourceAdapter\XMLAdapter;
use Goetas\TwitalBundle\Extension\TranslateExtension;


class CoreAttributeTest extends \PHPUnit_Framework_TestCase
{
    protected $twital;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
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
    public function testVisitAttributeDynamic($source, $expected, $matcher)
    {
        $compiled = $this->twital->compile($this->sourceAdapter, $source);
        $mch = null;
        $this->assertTrue(preg_match($matcher, $compiled, $mch) > 0);

        $this->assertEquals($expected, str_replace($mch[1], 'XxX', $compiled));
    }

    public function getDataDynamic()
    {
        $matcher = '/{% set (.*?) /';
        $attrReplacer = '{% for ____ak,____av in XxX if (____av|length>0) and not (____av|length == 1 and ____av[0] is same as(false)) %} {{____ak | raw}}{% if ____av|length > 1 or ____av[0] is not same as(true) %}="{{ ____av|join(\'\') }}"{% endif %}{% endfor %}';
        return array(

            //trans-attr
            array('<div class="foo" t:trans-attr="class">content</div>', '{% set XxX = XxX|default({})|merge({\'class\':[\'foo\'|trans()]}) %}<div' . $attrReplacer . '>content</div>', $matcher),
            array('<div class="foo" t:trans-attr="class:[{\'%var%\':var}]">content</div>', '{% set XxX = XxX|default({})|merge({\'class\':[\'foo\'|trans({\'%var%\':var})]}) %}<div' . $attrReplacer . '>content</div>', $matcher),
            array('<div class="foo" t:trans-attr="class:[{\'%var%\':var}, \'domain\']">content</div>', '{% set XxX = XxX|default({})|merge({\'class\':[\'foo\'|trans({\'%var%\':var}, \'domain\')]}) %}<div' . $attrReplacer . '>content</div>', $matcher),
            //trans-attr multiple
            array('<div class="foo" alt="bar" t:trans-attr="class, alt">content</div>', '{% set XxX = XxX|default({})|merge({\'class\':[\'foo\'|trans()],\'alt\':[\'bar\'|trans()]}) %}<div' . $attrReplacer . '>content</div>', $matcher),
            array('<div class="foo" alt="bar" t:trans-attr="class:[{\'%var%\':var}], alt">content</div>', '{% set XxX = XxX|default({})|merge({\'class\':[\'foo\'|trans({\'%var%\':var})],\'alt\':[\'bar\'|trans()]}) %}<div' . $attrReplacer . '>content</div>', $matcher),
            array('<div class="foo" alt="bar" t:trans-attr="class:[{\'%var%\':var}, \'domain\'], alt">content</div>', '{% set XxX = XxX|default({})|merge({\'class\':[\'foo\'|trans({\'%var%\':var}, \'domain\')],\'alt\':[\'bar\'|trans()]}) %}<div' . $attrReplacer . '>content</div>', $matcher),

            //trans-attr-n
            array('<div class="foo" t:trans-attr-n="class:[n]">content</div>', '{% set XxX = XxX|default({})|merge({\'class\':[\'foo\'|transchoice(n)]}) %}<div' . $attrReplacer . '>content</div>', $matcher),
            array('<div class="foo" alt="bar" t:trans-attr-n="class:[n], alt:[x]">content</div>', '{% set XxX = XxX|default({})|merge({\'class\':[\'foo\'|transchoice(n)],\'alt\':[\'bar\'|transchoice(x)]}) %}<div' . $attrReplacer . '>content</div>', $matcher),
            array('<div class="foo" t:trans-attr-n="class:[n, {\'%var%\':var}]">content</div>', '{% set XxX = XxX|default({})|merge({\'class\':[\'foo\'|transchoice(n, {\'%var%\':var})]}) %}<div' . $attrReplacer . '>content</div>', $matcher),
            array('<div class="foo" t:trans-attr-n="class:[n, {\'%var%\':var}, \'domain\']">content</div>', '{% set XxX = XxX|default({})|merge({\'class\':[\'foo\'|transchoice(n, {\'%var%\':var}, \'domain\')]}) %}<div' . $attrReplacer . '>content</div>', $matcher),

            // combined
            array('<div class="foo" alt="bar" t:trans-attr-n="class:[n]" t:trans-attr="alt">content</div>', '{% set XxX = XxX|default({})|merge({\'class\':[\'foo\'|transchoice(n)]}) %}{% set XxX = XxX|default({})|merge({\'alt\':[\'bar\'|trans()]}) %}<div' . $attrReplacer . '>content</div>', $matcher),
            array('<div class="foo" alt="bar" t:trans-attr-n="class:[n]" t:trans-attr="alt" t:trans="">content</div>', '{% set XxX = XxX|default({})|merge({\'class\':[\'foo\'|transchoice(n)]}) %}{% set XxX = XxX|default({})|merge({\'alt\':[\'bar\'|trans()]}) %}<div' . $attrReplacer . '>{% trans %}content{% endtrans %}</div>', $matcher),

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



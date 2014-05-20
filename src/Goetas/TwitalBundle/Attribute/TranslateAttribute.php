<?php
namespace Goetas\TwitalBundle\Attribute;

use Goetas\Twital\Attribute;
use Goetas\Twital\Compiler;
use DOMAttr;
use Goetas\Twital\Helper\ParserHelper;

/**
 *
 * @author Asmir Mustafic <goetas@gmail.com>
 *
 */
class TranslateAttribute implements Attribute
{

    public function visit(DOMAttr $att, Compiler $context)
    {
        $node = $att->ownerElement;

        $expessions = ParserHelper::staticSplitExpression(html_entity_decode($att->value), ",");

        $params = 'trans';
        if (isset($expessions[0]) && trim($expessions[0])) {
            $params .= " with " . $expessions[0];
        }
        if (isset($expessions[1]) && strlen($expessions[1])) {
            $params .= " from " . $expessions[1];
        }

        $start = $context->createControlNode($params);
        $end = $context->createControlNode("endtrans");

        $node->insertBefore($start, $node->firstChild);

        $node->appendChild($end);

        $node->removeAttributeNode($att);
    }
}

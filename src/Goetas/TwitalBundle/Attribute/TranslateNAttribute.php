<?php

namespace Goetas\TwitalBundle\Attribute;

use DOMAttr;
use Goetas\Twital\Attribute;
use Goetas\Twital\Compiler;
use Goetas\Twital\Helper\ParserHelper;

/**
 *
 * @author Asmir Mustafic <goetas@gmail.com>
 *
 */
class TranslateNAttribute implements Attribute
{

    public function visit(DOMAttr $att, Compiler $context)
    {
        $node = $att->ownerElement;

        $expessions = ParserHelper::staticSplitExpression($att->value, ",");

        if (!isset($expessions[0]) || !strlen($expessions[0])) {
            throw new \Exception("The count for trans-n is required");
        }

        $with = '{\'%count%\':' . $expessions[0] . '}';

        if (isset($expessions[1]) && strlen($expessions[1])) {
            $with = "$with|merge(" . $expessions[1] . ')';
        }

        $from = '';
        if (isset($expessions[2]) && strlen($expessions[2])) {
            $from = " from $expessions[2]";
        }

        $start = $context->createControlNode("transchoice " . $expessions[0] . " with $with" . $from);
        $end = $context->createControlNode("endtranschoice");

        $node->insertBefore($start, $node->firstChild);

        $node->appendChild($end);

        $node->removeAttributeNode($att);
    }
}

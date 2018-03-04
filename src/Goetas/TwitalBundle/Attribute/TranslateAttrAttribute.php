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
class TranslateAttrAttribute implements Attribute
{

    public static function getVarname(\DOMNode $node)
    {
        return "__a" . str_replace("-", "_", spl_object_hash($node));
    }

    public function visit(DOMAttr $att, Compiler $context)
    {
        $node = $att->ownerElement;
        $expressions = ParserHelper::staticSplitExpression($att->value, ",");
        $varName = self::getVarname($node);

        $parts = array();

        foreach ($expressions as $expression) {

            $attrExpr = ParserHelper::staticSplitExpression($expression, ":");

            if (!$node->hasAttribute($attrExpr[0])) {
                throw new \Exception("Can't find the attribute named '" . $attrExpr[0] . "'");
            }

            $attNode = $node->getAttributeNode($attrExpr[0]);

            $transParams = isset($attrExpr[1]) ? ParserHelper::staticSplitExpression(trim($attrExpr[1], "[]\n\r\t"), ",") : array();

            $parts[$attrExpr[0]] = "['" . addcslashes($attNode->value, "'") . "'|trans(" . (isset($transParams[0]) ? ($transParams[0]) : '') . (isset($transParams[1]) ? ", $transParams[1]" : "") . ")]";

            $node->removeAttributeNode($attNode);
        }

        $code = "set $varName = $varName|default({})|merge({" . ParserHelper::implodeKeyed(",", $parts, true) . "})";
        $node->setAttribute("__attr__", $varName);

        $pi = $context->createControlNode($code);

        $node->parentNode->insertBefore($pi, $node);

        $node->removeAttributeNode($att);
    }
}

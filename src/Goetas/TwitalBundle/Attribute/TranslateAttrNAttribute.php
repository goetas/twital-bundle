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
class TranslateAttrNAttribute implements Attribute
{

    public static function getVarname(\DOMNode $node)
    {
        return "__a" .str_replace("-", "_", spl_object_hash($node));
    }

    public function visit(DOMAttr $att, Compiler $context)
    {
        $node = $att->ownerElement;
        $expressions = ParserHelper::staticSplitExpression($att->value, ",");
        $varName = self::getVarname($node);

        $parts = array();

        foreach ($expressions as $expression) {

            $attrExpr = ParserHelper::staticSplitExpression($expression, ":", 2);

            if (! $node->hasAttribute($attrExpr[0])) {
                throw new \Exception("non trovo l'attributo " . $attrExpr[0] . " da tradurre");
            }
            $attNode = $node->getAttributeNode($attrExpr[0]);

            $transParams = isset($attrExpr[1])?trim($attrExpr[1], "\n\t\r []"):array();
            $transParams = ParserHelper::staticSplitExpression($transParams, ",", 2);

            $parts[$attrExpr[0]] = "['" . addcslashes($attNode->value, "'") . "'|transchoice($transParams[0]" . (isset($transParams[1]) ? (", " . $transParams[1]) : '') . "" . (isset($transParams[2]) ? ", $transParams[2]" : "") . ")]";

            $node->removeAttributeNode($attNode);
        }

        $code = "set $varName = $varName|default({})|merge({" . ParserHelper::implodeKeyed(",", $parts, true) . "})";

        $node->setAttribute("__attr__", $varName);

        $pi = $context->createControlNode($code);

        $node->parentNode->insertBefore($pi, $node);

        $node->removeAttributeNode($att);
    }
}

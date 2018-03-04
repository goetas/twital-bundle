<?php

namespace Goetas\TwitalBundle\Extension;

use Goetas\Twital\Extension\AbstractExtension;
use Goetas\Twital\Twital;
use Goetas\TwitalBundle\Attribute;
use Goetas\TwitalBundle\EventSubscriber\WhiteSpaceRemovalSubscriber;

/**
 *
 * @author Asmir Mustafic <goetas@gmail.com>
 *
 */
class TranslateExtension extends AbstractExtension
{

    public function getSubscribers()
    {
        return array(
            new WhiteSpaceRemovalSubscriber(array(), array('http://www.w3.org/1999/xhtml'))
        );
    }

    public function getAttributes()
    {
        $attributes = array();

        $attributes[Twital::NS]['trans'] = new Attribute\TranslateAttribute();
        $attributes[Twital::NS]['trans-n'] = new Attribute\TranslateNAttribute();
        $attributes[Twital::NS]['trans-attr'] = new Attribute\TranslateAttrAttribute();
        $attributes[Twital::NS]['trans-attr-n'] = new Attribute\TranslateAttrNAttribute();

        return $attributes;
    }
}

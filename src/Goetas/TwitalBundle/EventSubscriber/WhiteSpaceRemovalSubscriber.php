<?php
namespace Goetas\TwitalBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Goetas\Twital\EventDispatcher\SourceEvent;
use Goetas\Twital\EventDispatcher\TemplateEvent;
use Goetas\Twital\Twital;

/**
 *
 * @author Asmir Mustafic <goetas@gmail.com>
 *
 */
class WhiteSpaceRemovalSubscriber implements EventSubscriberInterface
{

    protected $allowedTags = array();

    protected $allowedNamespaces = array();

    public function __construct(array $allowedTags = array(), array $allowedNamespaces = array())
    {
        $this->allowedTags = $allowedTags;
        $this->allowedNamespaces = $allowedNamespaces;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'compiler.post_load' => array( 'removeWhitespace', - 10)
        );
    }

    public function removeWhitespace(TemplateEvent $event)
    {
        $doc = $event->getTemplate()->getDocument();

        $xp = new \DOMXPath($doc);
        $xp->registerNamespace("t", Twital::NS);

        foreach ($xp->query("//text()[ancestor::*[@t:trans or @t:trans-n]]", $doc, false) as $text) {
            if ($this->isAllowedNode($text->parentNode)) {
                $text->data = preg_replace('/\s+/', ' ', $text->data);

                if ($text->parentNode->childNodes->length === 1) {
                    $trimmed = trim($text->data);
                    if(!strlen($trimmed) && strlen($text->data)){
                        $trimmed =" ";
                    }
                    $text->data = $trimmed;
                } elseif ($text->parentNode->hasAttributeNs(Twital::NS, 'trans') || $text->parentNode->hasAttributeNs(Twital::NS, 'trans-n')) {
                    if ($text->parentNode->firstChild === $text) {
                        $text->data = ltrim($text->data);
                    }elseif ($text->parentNode->lastChild === $text) {
                        $text->data = rtrim($text->data);
                    }
                }
            }
        }
    }
    private function isAllowedNode(\DOMElement $element) {

        if ($this->allowedTags && !in_array($element->parentNode->localName, $this->allowedTags)) {
        	return false;
        }

        if ($this->allowedNamespaces && !in_array($element->parentNode->namespaceURI, $this->allowedNamespaces)) {
            return false;
        }

        return true;
    }
}
<?php

namespace Goetas\TwitalBundle\Translation\Jms;

use Goetas\Twital\TwitalLoader;
use JMS\TranslationBundle\Model\MessageCatalogue;
use JMS\TranslationBundle\Translation\Extractor\File\TwigFileExtractor;
use JMS\TranslationBundle\Translation\Extractor\FileVisitorInterface;
use Twig\Source;

/**
 *
 * @author Asmir Mustafic <goetas@gmail.com>
 *
 */
class TwitalExtractor implements FileVisitorInterface
{
    /**
     *
     * @var TwigFileExtractor
     */
    private $twigFileExtractor;
    /**
     *
     * @var \Goetas\Twital\TwitalLoader
     */
    private $twitalLoader;
    /**
     *
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(\Twig_Environment $twig, TwitalLoader $twitalLoader, TwigFileExtractor $twigFileExtractor)
    {
        $this->twig = $twig;
        $this->twitalLoader = $twitalLoader;
        $this->twigFileExtractor = $twigFileExtractor;
    }

    public function visitPhpFile(\SplFileInfo $file, MessageCatalogue $catalogue, array $ast)
    {
    }

    public function visitTwigFile(\SplFileInfo $file, MessageCatalogue $catalogue, \Twig_Node $ast)
    {
        if ($adapter = $this->twitalLoader->getSourceAdapter((string)$file)) {

            $source = $this->twitalLoader->getTwital()->compile($adapter, file_get_contents((string)$file));

            $ast = $this->twig->parse($this->twig->tokenize(new Source($source, (string)$file)));
        }

        $this->twigFileExtractor->visitTwigFile($file, $catalogue, $ast);
    }

    function visitFile(\SplFileInfo $file, MessageCatalogue $catalogue)
    {
        if ($adapter = $this->twitalLoader->getSourceAdapter((string)$file)) {

            $source = $this->twitalLoader->getTwital()->compile($adapter, file_get_contents((string)$file));

            $ast = $this->twig->parse($this->twig->tokenize(new Source($source, (string)$file)));

            $this->twigFileExtractor->visitTwigFile($file, $catalogue, $ast);
        }
    }
}

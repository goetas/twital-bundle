<?php
namespace Goetas\TwitalBundle\Translation\Jms;

use JMS\TranslationBundle\Model\MessageCatalogue;
use JMS\TranslationBundle\Translation\Extractor\File\TwigFileExtractor;
use Goetas\Twital\TwitalLoader;
use JMS\TranslationBundle\Translation\FileSourceFactory;

/**
 *
 * @author Asmir Mustafic <goetas@gmail.com>
 *
 */
class TwitalExtractor extends TwigFileExtractor
{

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

	public function __construct(\Twig_Environment $twig, FileSourceFactory $fileSourceFactory, TwitalLoader $twitalLoader)
	{
		parent::__construct($twig, $fileSourceFactory);
        $this->twig = $twig;
        $this->twitalLoader = $twitalLoader;
    }

    function visitFile(\SplFileInfo $file, MessageCatalogue $catalogue)
    {
        if ($file->getExtension() == 'twital' && ($adapter = $this->twitalLoader->getSourceAdapter((string)$file))) {

            $source = $this->twitalLoader->getTwital()->compile($adapter, file_get_contents((string)$file));

            $ast = $this->twig->parse($this->twig->tokenize($source, (string)$file));

            $this->visitTwigFile($file, $catalogue, $ast);
        }
    }
}

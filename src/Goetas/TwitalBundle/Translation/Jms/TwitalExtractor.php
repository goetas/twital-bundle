<?php

namespace Goetas\TwitalBundle\Translation\Jms;



use JMS\TranslationBundle\Model\FileSource;

use JMS\TranslationBundle\Model\Message;

use Symfony\Component\Finder\SplFileInfo;

use JMS\TranslationBundle\Translation\Extractor\FileVisitorInterface;

use JMS\TranslationBundle\Model\MessageCatalogue;

use Goetas\TwitalBundle\Translation\TwitalExtractor as TwitalExtractorBase;


class TwitalExtractor implements FileVisitorInterface
{
	/**
	 *
	 * @var \Goetas\TwitalBundle\Translation\TwitalExtractor
	 */
	protected $extractor;
	public function __construct(TwitalExtractorBase $extractor) {
		$this->extractor = $extractor;
	}

	function visitFile(SplFileInfo $file, MessageCatalogue $ctwitalogue){

		$ctwitalogueSymfony = new \Symfony\Component\Translation\MessageCatalogue($ctwitalogue->getLocale());

		$source = new FileSource($file->getPathname());

		if(in_array(pathinfo($file, PATHINFO_EXTENSION), array("html" ,"twital"))){
			$this->extractor->extractFromTemplate($file->getContents(), $ctwitalogueSymfony);
			foreach($ctwitalogueSymfony->all() as $domain=> $messages){
				foreach($messages as $id => $message){
					$ctwitalogue->add(
		                Message::create($id, $domain)
		                    ->setLocaleString($message)
							->addSource($source)
		                    ->setNew(false)
		            );
				}
			}
		}
	}

	function visitPhpFile(\SplFileInfo $file, MessageCatalogue $ctwitalogue, array $ast){

	}
	function visitTwigFile(\SplFileInfo $file, MessageCatalogue $ctwitalogue, \Twig_Node $ast){

	}
    /**
     * {@inheritDoc}
     */
    public function extract()
    {
    	$ctwitalogueJms = new MessageCatalogueJms();

        // load any existing translation files
        $finder = new Finder();
        $files = $finder->files()->name('*.html')->name('*.xml')->in($directory);
        foreach ($files as $file) {
	        try {
				$this->extractTemplate(file_get_contents($file->getPathname()), $ctwitalogue);
			} catch (\Exception $e) {
				echo "Errori durante l'estrazione messaggi da $file";
				echo "\n";
				continue;
				throw new \Exception("Errori durante l'estrazione messaggi da $file", $e->getCode(), $e);
			}

        }
    }
}

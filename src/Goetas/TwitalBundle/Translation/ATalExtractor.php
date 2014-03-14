<?php

namespace Goetas\TwitalBundle\Translation;

use goetas\twital\plugins\attributes\Attribute_translate;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Translation\Extractor\ExtractorInterface;
use Symfony\Component\Translation\MessageCatalogue;

class TwitalExtractor implements ExtractorInterface
{
    /**
     * Default domain for found messages.
     *
     * @var string
     */
    private $defaultDomain = 'messages';

    /**
     * Prefix for found message.
     *
     * @var string
     */
    private $prefix = '';

    public function __construct()
    {

    }

    /**
     * {@inheritDoc}
     */
    public function extract($directory, MessageCatalogue $ctwitalogue)
    {
        // load any existing translation files
        $finder = new Finder();
        $files = $finder->files()->name(".twital")->in($directory);
        foreach ($files as $file) {
	        try {
				$this->extractFromTemplate(file_get_contents($file->getPathname()), $ctwitalogue);
			} catch (\Exception $e) {
				echo "Errori durante l'estrazione messaggi da $file";
				echo "\n";
				continue;
				throw new \Exception("Errori durante l'estrazione messaggi da $file", $e->getCode(), $e);
			}

        }
    }

    /**
     * {@inheritDoc}
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    public function extractFromTemplate($xmlString, MessageCatalogue $ctwitalogue)
    {
    	if(!preg_match('/xmlns:[a-z]+=("|\')Twital("|\')/', $xmlString)){
    		return;
    	}

		$xmlString = str_replace( array_keys( self::$htmlEntities ), self::$htmlEntities, $xmlString );

		$dom = new \goetas\xml\XMLDom();
		$dom->loadXMLStrict($xmlString);
		$nodes = $dom->xpath( "//@t:translate|//@t:translate-attr|//@t:translate-var" , array("t" => "Twital" ) );
		foreach ( $nodes as $attr ){
			if($attr->localName=="translate"){

				$txt = Attribute_translate::extractStringFromNode($attr->ownerElement);

				$ctwitalogue->set($txt, $this->prefix.$txt, $this->defaultDomain);

			}elseif($attr->localName=="translate-var"){

				$parts = self::splitExpression($attr->value,";");

				foreach ($parts as $part){

					$partsTr = self::splitExpression( $part, "|" );

					list ( $varName, $text ) = self::splitExpression( $partsTr[0], "=" );

					$txt = stripcslashes(substr(trim($text),1,-1));

					$ctwitalogue->set($txt, $this->prefix.$txt, $this->defaultDomain);
				}
			}elseif($attr->localName=="translate-attr"){
				$attributi = array();

				$parts = self::splitExpression($attr->value,";");

				foreach($parts as $part){
					$mch=array();
					if(preg_match("/^([a-z:_\\-0-9]+)\\s*\\((.+)/i",$part,$mch)){
						$attributi[]=$mch[1];
					}else{
						$attributi[]=$part;
					}
				}

				foreach ($attributi as $attributo){
					$txt = $attr->ownerElement->getAttribute($attributo);
					$ctwitalogue->set($txt, $this->prefix.$txt, $this->defaultDomain);
				}
			}

		}
    }
	protected static function splitExpression($str, $splitrer) {
		$str = str_split( $str, 1 );
		$str [] = " ";
		$str_len = count( $str );

		$splitrer = str_split( $splitrer, 1 );
		$splitrer_len = count( $splitrer );

		$parts = array();
		$inApex = false;
		$next = 0;
		$pcount = 0;
		for($i = 0; $i < $str_len; $i ++){
			if($inApex === false && ($i === 0 || $str [$i - 1] !== "\\") && ($str [$i] === "\"" || $str [$i] === "'")){ // ingresso
				$inApex = $str [$i];
			}elseif($inApex === $str [$i] && $str [$i - 1] !== "\\"){ // uscita
				$inApex = false;
			}
			if($inApex === false && $str [$i] === "("){
				$pcount ++;
			}elseif($inApex === false && $str [$i] === ")"){
				$pcount --;
			}
			if($inApex === false && $pcount === 0 && (array_slice( $str, $i, $splitrer_len ) == $splitrer || $i == ($str_len - 1))){
				$val = trim( implode( '', array_slice( $str, $next, $i - $next ) ) );
				if(strlen( $val )){
					$parts [] = $val;
				}
				$next = $i + $splitrer_len;
			}
		}
		if($pcount!==0){
			throw new \Exception("Perentesi non bilanciate nell'espressione '$str'");
		}
		if($inApex!==false){
			throw new \Exception("Apici non bilanciati nell'espressione '$str'");
		}
		return $parts;
	}
}

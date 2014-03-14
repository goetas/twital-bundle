<?php
namespace Goetas\TwitalBundle\Assetic;

use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;

use goetas\xml\XMLDom;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Assetic\Factory\AssetFactory;

use Assetic\Factory\Resource\ResourceInterface;

use Assetic\Factory\Loader\FormulaLoaderInterface;

class TwitalAsseticLoader implements FormulaLoaderInterface{
    protected $factory;

    public function __construct(AssetFactory $factory)
    {
        $this->factory = $factory;
    }
	function load(ResourceInterface $resource){
		$formula = array();

		$nRes = new FileResource($resource);

		$str = $nRes->getContent();

		if (!$str){
			return $formula;
		}

		$str = preg_replace("/(&[a-z]+;)/i", "",  $str);

		$dom = new XMLDom();
		$dom->loadXMLStrict($str);

		foreach ($dom->query("//as:javascripts", array("as"=>"Twital:Assetic")) as $node){

			if($node->hasAttribute("filter")){
				$filters=explode(",",$node->getAttribute("filter"));
			}else{
				$filters = array();
			}

			$inputs = array();
			foreach ($node->query("xh:script",array("xh"=>"http://www.w3.org/1999/xhtml")) as $script){
		        $inputs[]=$script->getAttribute("src");
			}
			$options = array();
			if($node->hasAttribute("output")){
				$options['output']=$node->getAttribute("output");
			}else{
				$options['output']="assetic/js/*.js";
			}

			if(count($inputs)){
				$formula  += $this->processCall($inputs, $options, $filters);
			}
		}


		foreach ($dom->query("//as:stylesheets", array("as"=>"Twital:Assetic")) as $node){

			$filters = array();

			if($node->hasAttribute("filter")){
				$filters=explode(",",$node->getAttribute("filter"));
			}

			$inputs = array();
			foreach ($node->query ( "xh:link", array ("xh" => "http://www.w3.org/1999/xhtml" ) ) as $link){
				$inputs[]=$link->getAttribute("href");
			}

			$options = array();
			if($node->hasAttribute("output")){
				$options['output']=$node->getAttribute("output");
			}else{
				$options['output']="assetic/css/*.css";
			}

			if(count($inputs)){
				$formula  += $this->processCall($inputs, $options, $filters);
			}
		}

        return $formula;
	}
	static private function createTemplateReference($bundle, $file)
    {
        $parts = explode('/', strtr($file, '\\', '/'));
        $elements = explode('.', array_pop($parts));

        return new TemplateReference($bundle, implode('/', $parts), $elements[0], $elements[1], 'twital');
    }

    private function processCall($inputs, array $options = array(), array $filters = array())
    {
        $explode = function($value)
        {
            return array_map('trim', explode(',', $value));
        };

        if (!is_array($inputs)) {
            $inputs = $explode($inputs);
        }

        if (!is_array($filters)) {
            $filters = $explode($filters);
        }

        if (!isset($options['debug'])) {
            $options['debug'] = $this->factory->isDebug();
        }

        if (!isset($options['combine'])) {
            $options['combine'] = !$options['debug'];
        }

        if (isset($options['single']) && $options['single'] && 1 < count($inputs)) {
            $inputs = array_slice($inputs, -1);
        }

        if (!isset($options['name'])) {
            $options['name'] = $this->factory->generateAssetName($inputs, $filters, $options);
        }
        return array($options['name'] => array($inputs, $filters, $options));
    }
}
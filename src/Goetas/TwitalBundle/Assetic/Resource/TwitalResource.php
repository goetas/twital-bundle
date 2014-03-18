<?php
namespace Goetas\TwitalBundle\Assetic\Resource;

use Assetic\Factory\Resource\ResourceInterface;
use Goetas\Twital\TwitalLoader;

class TwitalResource implements ResourceInterface
{

    private $loader;

    private $resource;

    public function __construct(TwitalLoader $loader, ResourceInterface $resource)
    {
        $this->loader = $loader;
        $this->resource = $resource;
    }

    public function getContent()
    {
        $source = $this->resource->getContent();

        if ($adapter = $this->loader->getSourceAdapter(strval($this->resource))) {
            $source = $this->loader->getTwital()->compile($adapter, $source);
        }

        return $source;
    }

    public function isFresh($timestamp)
    {
        return $this->resource->isFresh($timestamp);
    }

    public function __toString()
    {
        return strval($this->resource);
    }
}

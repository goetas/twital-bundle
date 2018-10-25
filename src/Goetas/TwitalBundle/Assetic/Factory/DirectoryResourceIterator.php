<?php

namespace Goetas\TwitalBundle\Assetic\Factory;

use Symfony\Component\Templating\Loader\LoaderInterface;

class DirectoryResourceIterator extends \RecursiveIteratorIterator
{
    protected $loader;

    protected $bundle;

    protected $path;

    /**
     * @param LoaderInterface $loader The templating loader
     * @param string $path The directory
     * @param \RecursiveIterator $iterator The inner iterator
     */
    public function __construct(LoaderInterface $loader, $path, \RecursiveIterator $iterator)
    {
        $this->loader = $loader;
        $this->path = $path;

        parent::__construct($iterator);
    }

    public function current()
    {
        $file = parent::current();

        return new FileResource($this->loader, $this->path, $file->getPathname());
    }
}

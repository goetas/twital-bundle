<?php

namespace Goetas\TwitalBundle\Assetic\Factory;

use Assetic\Factory\Resource\DirectoryResource as BaseDirectoryResource;
use Symfony\Component\Templating\Loader\LoaderInterface;

class DirectoryResource extends BaseDirectoryResource
{
    protected $loader;

    protected $path;

    /**
     * @param LoaderInterface $loader The templating loader
     * @param string $path The directory path
     * @param string $pattern A regex pattern for file basenames
     */
    public function __construct(LoaderInterface $loader, $path, $pattern = null)
    {
        $this->loader = $loader;
        $this->path = rtrim($path, '/') . '/';

        parent::__construct($path, $pattern);
    }

    public function getIterator()
    {
        return is_dir($this->path)
            ? new DirectoryResourceIterator($this->loader, $this->path, $this->getInnerIterator())
            : new \EmptyIterator();
    }
}

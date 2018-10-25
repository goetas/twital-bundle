<?php

namespace Goetas\TwitalBundle\Assetic\Factory;

use Assetic\Factory\Resource\ResourceInterface;
use Symfony\Component\Templating\Loader\LoaderInterface;
use Symfony\Component\Templating\TemplateReference;

class FileResource implements ResourceInterface
{
    protected $loader;

    protected $path;

    protected $baseDir;

    protected $template;

    /**
     * Constructor.
     *
     * @param LoaderInterface $loader The templating loader
     * @param string $baseDir The directory
     * @param string $path The file path
     */
    public function __construct(LoaderInterface $loader, $baseDir, $path)
    {
        $this->loader = $loader;
        $this->baseDir = $baseDir;
        $this->path = $path;
    }

    public function isFresh($timestamp)
    {
        return $this->loader->isFresh($this->getTemplate(), $timestamp);
    }

    public function getContent()
    {
        $templateReference = $this->getTemplate();
        $fileResource = $this->loader->load($templateReference);

        if (!$fileResource) {
            throw new \InvalidArgumentException(sprintf('Unable to find template "%s".', $templateReference));
        }

        return $fileResource->getContent();
    }

    public function __toString()
    {
        return (string)$this->getTemplate();
    }

    protected function getTemplate()
    {
        if (null === $this->template) {
            $this->template = new TemplateReference($this->path, 'twital');
        }

        return $this->template;
    }
}

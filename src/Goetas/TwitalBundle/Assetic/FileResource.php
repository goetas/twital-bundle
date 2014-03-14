<?php

/*
 * This file is part of the Symfony framework.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Goetas\TwitalBundle\Assetic;

use Symfony\Bundle\FrameworkBundle\Templating\TemplateReference;

use Symfony\Bundle\AsseticBundle\Factory\Resource\FileResource as FileResourceBase;

use Assetic\Factory\Resource\ResourceInterface;
use Symfony\Component\Templating\Loader\LoaderInterface;

/**
 * A file resource.
 *
 * @author Kris Wallsmith <kris@symfony.com>
 */
class FileResource extends FileResourceBase
{

    public function __construct(FileResourceBase $fr)
    {
        parent::__construct($fr->loader, $fr->bundle, $fr->baseDir, $fr->path);
    }

    protected function getTemplate()
    {
        if (null === $this->template) {
            $this->template = self::createNTemplateReference($this->bundle, substr($this->path, strlen($this->baseDir)));
        }

        return $this->template;
    }

    static private function createNTemplateReference($bundle, $file)
    {
        $parts = explode('/', strtr($file, '\\', '/'));
        $elements = explode('.', array_pop($parts));

        return new TemplateReference($bundle, implode('/', $parts), $elements[0], $elements[1], 'twital');
    }
}

<?php

namespace Goetas\TwitalBundle\DependencyInjection;

use Goetas\TwitalBundle\Assetic\Factory\DirectoryResource;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class DirectoryResourceDefinition extends Definition
{
    /**
     * Constructor.
     *
     * @param string $bundle A bundle name or empty string
     * @param string $engine The templating engine
     * @param array $dirs An array of directories to merge
     */
    public function __construct($bundle, $engine, $regex, array $dirs)
    {
        if (!count($dirs)) {
            throw new \InvalidArgumentException('You must provide at least one directory.');
        }

        parent::__construct();

        $this
            ->addTag('assetic.templating.' . $engine)
            ->addTag('assetic.formula_resource', array('loader' => $engine));;

        if (1 == count($dirs)) {
            // no need to coalesce
            self::configureDefinition($this, $regex, reset($dirs));

            return;
        }

        // gather the wrapped resource definitions
        $resources = array();
        foreach ($dirs as $dir) {
            $resources[] = $resource = new Definition();
            self::configureDefinition($resource, $regex, $dir);
        }

        $this
            ->setClass('%assetic.coalescing_directory_resource.class%')
            ->addArgument($resources)
            ->setPublic(false);
    }

    private static function configureDefinition(Definition $definition, $regex, $dir)
    {
        $definition
            ->setClass('Goetas\TwitalBundle\Assetic\Factory\DirectoryResource')
            ->addArgument(new Reference('templating.loader'))
            ->addArgument($dir)
            ->addArgument($regex)
            ->setPublic(false);
    }
}

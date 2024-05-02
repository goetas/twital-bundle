<?php

namespace Goetas\TwitalBundle\CacheWarmer;

use Symfony\Bundle\FrameworkBundle\CacheWarmer\TemplateFinderInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;
use Twig\Error\Error;

class TemplateCacheCacheWarmer implements CacheWarmerInterface
{
    protected $container;
    protected $finder;

    /**
     * Constructor.
     *
     * @param ContainerInterface $container The dependency injection container
     * @param TemplateFinderInterface $finder The template paths cache warmer
     */
    public function __construct(ContainerInterface $container, TemplateFinderInterface $finder)
    {
        // We don't inject the Twig environment directly as it depends on the
        // template locator (via the loader) which might be a cached one.
        // The cached template locator is available once the TemplatePathsCacheWarmer
        // has been warmed up
        $this->container = $container;
        $this->finder = $finder;
    }

    /**
     * Warms up the cache.
     *
     * @param string $cacheDir The cache directory
     */
    public function warmUp($cacheDir)
    {
        $twig = $this->container->get('twig');

        foreach ($this->finder->findAllTemplates() as $template) {

            if ('twital' !== $template->get('engine')) {
                continue;
            }

            try {
                $twig->loadTemplate($template);
            } catch (Error $e) {
                // problem during compilation, give up
            }
        }
    }

    /**
     * Checks whether this warmer is optional or not.
     *
     * @return bool    always true
     */
    public function isOptional()
    {
        return true;
    }
}

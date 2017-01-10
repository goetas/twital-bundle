<?php

namespace Goetas\TwitalBundle\CacheWarmer;

use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\CacheWarmer\TemplateFinderInterface;


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

        $twitalLoader = $this->container->get('twital.loader');
        $twig = $this->container->get('twig');

        // switch the loaders
        $twitalLoader->setLoader($twig->getLoader());
        $twig->setLoader($twitalLoader);

        foreach ($this->finder->findAllTemplates() as $template) {

            if ('twital' !== $template->get('engine')) {
                continue;
            }

            try {
                $twig->loadTemplate($template);
            } catch (\Twig_Error $e) {
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

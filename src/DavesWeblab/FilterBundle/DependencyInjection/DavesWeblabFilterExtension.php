<?php

namespace DavesWeblab\FilterBundle\DependencyInjection;

use DavesWeblab\FilterBundle\FilterService;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class DavesWeblabFilterExtension extends ConfigurableExtension
{
    /**
     * Configures the passed container according to the merged configuration.
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load("services.yml");

        $this->configureHandlers($mergedConfig["iterator"]["handlers"], $container);
    }

    /**
     * @param array $handlers
     * @param ContainerBuilder $container
     */
    private function configureHandlers(array $handlers, ContainerBuilder $container)
    {
        $container->getDefinition(FilterService::class)->setArgument(0, $handlers);
    }
}
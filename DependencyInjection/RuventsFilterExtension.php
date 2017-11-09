<?php

namespace Ruvents\FilterBundle\DependencyInjection;

use Ruvents\FilterBundle\FilterManager;
use Ruvents\FilterBundle\FilterTypeInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class RuventsFilterExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $container->autowire(FilterManager::class)
            ->setPublic(false);

        $container->registerForAutoconfiguration(FilterTypeInterface::class)
            ->addTag('ruvents_filter_type');
    }
}
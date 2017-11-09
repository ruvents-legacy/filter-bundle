<?php

namespace Ruvents\FilterBundle;

use Ruvents\FilterBundle\DependencyInjection\Compiler\FilterPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class RuventsFilterBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new FilterPass());
    }
}

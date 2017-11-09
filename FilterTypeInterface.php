<?php

namespace Ruvents\FilterBundle;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

interface FilterTypeInterface
{
    public function buildForm(FormFactoryInterface $factory, array $options):FormInterface;

    public function configureOptions(OptionsResolver $resolver);
}

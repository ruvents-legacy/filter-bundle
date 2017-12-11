<?php

namespace Ruvents\FilterBundle\tests\Type;

use Ruvents\FilterBundle\Type\FilterTypeInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterTypeTest implements FilterTypeInterface
{
    public function createForm(FormFactoryInterface $factory, array $options): FormInterface
    {
        return $factory
            ->create()
            ->add('val1',TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([

            ]);
    }
}

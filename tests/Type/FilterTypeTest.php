<?php

namespace Ruvents\FilterBundle\tests\Type;

use Doctrine\ORM\QueryBuilder;
use Ruvents\FilterBundle\Type\FilterTypeInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterTypeTest implements FilterTypeInterface
{
    const TEST_VALUE = 1;

    public function createForm(FormFactoryInterface $factory, array $options): FormInterface
    {
        return $factory
            ->create()
            ->add('testMethod', TextType::class)
            ->submit([
                'testMethod' => self::TEST_VALUE,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
    }

    public function testMethodFilter($data, QueryBuilder $queryBuilder, array $options)
    {
        $queryBuilder->andWhere('a = :data')->setParameter('data', $data);
    }
}

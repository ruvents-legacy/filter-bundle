<?php

namespace Ruvents\FilterBundle\tests;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use PHPUnit\Framework\TestCase;
use Ruvents\FilterBundle\FilterManager;
use Ruvents\FilterBundle\tests\Type\FilterTypeTest;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormRegistry;
use Symfony\Component\Form\ResolvedFormTypeFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class FilterManagerTest extends TestCase
{
    /** @var TestContainer */
    private $container;

    /** @var FormFactory */
    private $formFactory;

    /** @var RequestStack */
    private $requestStack;

    /** @var EntityManager */
    private $entityManager;

    protected function setUp()
    {
        $this->container = new TestContainer();
        $this->formFactory = new FormFactory(new FormRegistry([], (new ResolvedFormTypeFactory())));
        $this->requestStack = new RequestStack();
        $this->entityManager = $this->getMockBuilder(EntityManagerInterface::class)->getMock();
    }

    /**
     * @expectedException \LogicException
     */
    public function testLogicException()
    {
        $serviceId = FilterTypeTest::class;
        $this->container->set($serviceId, new FilterTypeTest());

        $qb = (new QueryBuilder($this->entityManager));

        (new FilterManager($this->container, $this->formFactory, $this->requestStack))
            ->apply(FilterTypeTest::class, $qb);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidArgumentException()
    {
        $qb = (new QueryBuilder($this->entityManager));

        $this->requestStack->push(new Request());

        (new FilterManager($this->container, $this->formFactory, $this->requestStack))
            ->apply(FilterTypeTest::class, $qb);
    }
}

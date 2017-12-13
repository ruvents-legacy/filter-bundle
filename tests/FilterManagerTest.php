<?php

namespace Ruvents\FilterBundle\tests;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use PHPUnit\Framework\TestCase;
use Ruvents\FilterBundle\FilterManager;
use Ruvents\FilterBundle\tests\Type\FilterTypeTest;
use Ruvents\FilterBundle\tests\Type\FilterTypeTestWithoutSubmitData;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
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

    /** @var QueryBuilder */
    private $queryBuilder;

    /**
     * @expectedException \LogicException
     */
    public function testLogicException()
    {
        $serviceId = FilterTypeTest::class;
        $this->container->set($serviceId, new FilterTypeTest());

        (new FilterManager($this->container, $this->formFactory, $this->requestStack))
            ->apply(FilterTypeTest::class, $this->queryBuilder);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidArgumentException()
    {
        $this->requestStack->push(new Request());

        (new FilterManager($this->container, $this->formFactory, $this->requestStack))
            ->apply(FilterTypeTest::class, $this->queryBuilder);
    }

    public function testApply()
    {
        $serviceId = FilterTypeTest::class;
        $this->container->set($serviceId, new FilterTypeTest());

        $this->requestStack->push(new Request());

        $filterManager = new FilterManager($this->container, $this->formFactory, $this->requestStack);

        $filterResult = $filterManager->apply(FilterTypeTest::class, $this->queryBuilder, $options = []);

        $testForm = (new FilterTypeTest())->createForm($this->formFactory, []);

        $this->assertEquals($filterResult->getForm(), $testForm);
        $this->assertEquals($filterResult->getQueryBuilder(), $this->queryBuilder);
        $this->assertEquals($filterResult->getOptions(), $options);
        $this->assertEquals($filterResult->createView(), $testForm->createView());

        $actualValue = $filterResult->getQueryBuilder()->getParameters()[0]->getValue();
        $this->assertEquals(FilterTypeTest::TEST_VALUE, $actualValue);

        $expectedDql = 'SELECT WHERE a = :data';
        $this->assertEquals($expectedDql, $this->queryBuilder->getDQL());
    }

    protected function setUp()
    {
        $this->container = new TestContainer();
        $this->formFactory = (new FormFactory(
            new FormRegistry([new HttpFoundationExtension()], new ResolvedFormTypeFactory())
        ));
        $this->requestStack = new RequestStack();
        $this->queryBuilder = new MockQueryBuilder($this->createMock(EntityManagerInterface::class));
    }
}

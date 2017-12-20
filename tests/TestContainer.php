<?php
namespace Ruwork\DoctrineFilterBundle\tests;

use Psr\Container\ContainerInterface;

class TestContainer implements ContainerInterface
{
    private $container = [];

    public function set($name, $data)
    {
        $this->container[$name] = $data;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function get($id)
    {
        if (isset($this->container[$id])){
            return $this->container[$id];
        }

        throw new \OutOfBoundsException();
    }

    /**
     * {@inheritdoc}
     */
    public function has($id)
    {
        return isset($this->container[$id]);
    }
}

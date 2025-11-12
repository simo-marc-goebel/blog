<?php

namespace SimoMarcGoebel\Blog\Container;

use RuntimeException;

class SimpleContainer
{
    public function __construct(private array $config = [])
    {

    }
    public function get(string $id){
        if ($this->has($id)) {
            $factoryClassName = $this->config[$id];
            $factoryOrObject = new $factoryClassName($this);
            if ($isFactory = is_callable($factoryOrObject)) {
                return $factoryOrObject();
            }
            return $factoryOrObject;
        }

        throw new RuntimeException("Service not found: {$id}");
    }
    public function has(string $id) : bool
    {
        if (isset($this->config[$id])) {
            return true;
        }
        return false;
    }
}
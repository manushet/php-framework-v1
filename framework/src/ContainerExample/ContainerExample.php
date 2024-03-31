<?php
namespace Framework\ContainerExample;

use Framework\Container\Exception\ContainerException;
use Psr\Container\ContainerInterface;

class ContainerExample implements ContainerInterface
{
    private array $services = [];
    
    private function resolve($class)
    {
        $reflectionClass = new \ReflectionClass($class);

        $constructor = $reflectionClass->getConstructor();

        if (is_null($constructor)) {
            return $reflectionClass->newInstance();
        } 

        $constructorAttributes = $constructor->getParameters();

        $classDependencies = $this->resolveClassDependencies($constructorAttributes);

        return $reflectionClass->newInstanceArgs($classDependencies);
    }

    private function resolveClassDependencies(array $attrs): array
    {
        $classDependencies = [];

        /**
         * @var \ReflectionParameter $attr
         */
        foreach($attrs as $attr) {
            $serviceType = $attr->getType();

            $service = $this->get($serviceType->getName());
            
            $classDependencies[] = $service;
        }

        return $classDependencies;
    }
    
    public function add(string $id, string|object $instance = null) 
    {
        if (is_null($instance)) {
            if (!class_exists($id)) {
                throw new ContainerException("Service {$id} not found");
            }

            $instance = $id;
        }

        $this->services[$id] = $instance;
    }

    public function get(string $id)
    {
        if (!$this->has($id)) {
            if (!class_exists($id)) {
                throw new ContainerException("Service {$id} could not be resolved");
            }

            $this->add($id);
        }

        $serviceInstance = $this->resolve($this->services[$id]);

        return $serviceInstance;
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->services);
    }
}
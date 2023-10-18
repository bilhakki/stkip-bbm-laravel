<?php
namespace App\Enums;

class ReflectionClass
{
    private $className;

    public function __construct(string $className)
    {
        $this->className = $className;
    }

    public function getConstants(): array
    {
        $reflectionClass = new \ReflectionClass($this->className);
        return $reflectionClass->getConstants();
    }
}

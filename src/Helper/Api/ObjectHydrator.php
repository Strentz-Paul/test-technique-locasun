<?php

namespace App\Helper\Api;

use ReflectionClass;

abstract class ObjectHydrator
{
    /**
     * @param array<mixed> $values
     * @param object $input
     * @return object
     */
    public static function hydrate(array $values, object $input): object
    {
        $reflectionClass = new ReflectionClass($input);
        foreach ($values as $key => $value) {
            if (
                $reflectionClass->hasProperty($key) ||
                (
                    $reflectionClass->getParentClass() !== false &&
                    $reflectionClass->getParentClass()->hasProperty($key)
                )
            ) {
                $setter = 'set' . ucfirst($key);
                $input->$setter($value);
            }
        }

        return $input;
    }
}

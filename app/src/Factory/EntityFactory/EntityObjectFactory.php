<?php

namespace App\Factory\EntityFactory;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class EntityObjectFactory
{
    /**
     * Function works as Factory for creating entity objects from App\Entity\ namespace
     *
     * @param string $entityName
     * @return object
     */
    public static function getObjectForEntity(string $entityName): object
    {
        $class = "App\\Entity\\" . $entityName;

        if (!class_exists($class)) {
            throw new FileNotFoundException();
        }

        return new $class();
    }
}

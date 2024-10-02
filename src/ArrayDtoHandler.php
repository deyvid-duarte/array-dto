<?php

namespace DeyvidDuarte;

use ReflectionClass;
use ReflectionProperty;

class ArrayDtoHandler
{
	public static function validateSchema(object $class)
	{
		$reflection = new ReflectionClass($class);
		foreach ($reflection->getProperties() as $property) {
			$reflectionProperty = new ReflectionProperty($class, $property->name);
			$arrayDtoAttribute = $reflectionProperty->getAttributes(ArrayDto::class);
			if (empty($arrayDtoAttribute)) {
				continue;
			}
			$attributeInstance = $arrayDtoAttribute[0]->newInstance();
			$reflectionProperty->setAccessible(true);
			$attributeInstance->validateDto($reflectionProperty->getValue($class));
		}
	}
}
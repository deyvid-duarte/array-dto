<?php

namespace DeyvidDuarte;

use Attribute;
use InvalidArgumentException;

#[Attribute(Attribute::TARGET_PARAMETER | Attribute::TARGET_PROPERTY)]
class ArrayDto
{
	public function __construct(private array $dtoSchema)
	{
	}

	public function validateDto(array $propertyValue)
	{
		$this->validateSchemaStructure($propertyValue);
		$this->validateSchemaType($propertyValue);
	}

	private function validateSchemaStructure(array $propertyValue): void
	{
		$propertyKeys = array_keys($propertyValue);
		$schemaKeys = array_keys($this->dtoSchema);
		$schemaIsValid = count(array_intersect($propertyKeys, $schemaKeys)) == count($this->dtoSchema);
		if (!$schemaIsValid) {
			throw new InvalidArgumentException(
				sprintf(
					'Invalid DTO Schema: Expected structure %s but received %s',
					json_encode($schemaKeys), json_encode($propertyKeys)
				)
			);
		}
	}

	private function validateSchemaType(array $propertyValue): void
	{
		$isInvalid = false;
		$dtoSchemaKeys = array_keys($this->dtoSchema);
		$propertyKeysInvalid = $propertyValue;
		foreach ($dtoSchemaKeys as $key) {
			$propertyKeysInvalid[$key] = gettype($propertyValue[$key]);
			if (!$this->isCorrectType($propertyValue[$key], $this->dtoSchema[$key])) {
				$isInvalid = true;
			}
		}
		$isInvalid && throw new InvalidArgumentException(sprintf(
			'Invalid DTO Schema: Expected structure %s but received %s',
			json_encode($this->dtoSchema),
			json_encode($propertyKeysInvalid)
		));
	}

	private function isCorrectType(mixed $propertyTypeValue, string $correctPropertyType): bool
	{	
		$isSomething = "is_$correctPropertyType";
		if (function_exists($isSomething)) {
			return call_user_func($isSomething, $propertyTypeValue);
		}
		return $propertyTypeValue instanceof $correctPropertyType;
	}
}
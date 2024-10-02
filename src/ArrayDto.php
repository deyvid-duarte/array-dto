<?php

namespace DeyvidDuarte;

use Attribute;

#[Attribute(Attribute::TARGET_PARAMETER | Attribute::TARGET_PROPERTY)]
class ArrayDto
{
	public function __construct(private array $dtoSchema)
	{
	}

	public function validateDto(array $propertyValue)
	{
		var_dump($propertyValue);
		var_dump($this->dtoSchema);
	}
}
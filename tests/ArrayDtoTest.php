<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use DeyvidDuarte\{ArrayDto, ArrayDtoHandler};

final class ArrayDtoTest extends TestCase
{
	#[ArrayDto(['name' => 'string', 'age' => 'numeric'])]
	private array $user;
	private array $teste;

    public function test_deve_validar_que_o_array_nao_possui_os_indices_definidos(): void
    {
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('Invalid DTO Schema');

		$this->user = ['nome' => 'Deyvid Duarte', 'idade' => 29];
		ArrayDtoHandler::validateSchema($this);
    }
}
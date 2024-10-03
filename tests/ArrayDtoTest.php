<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use DeyvidDuarte\{ArrayDto, ArrayDtoHandler};

final class ArrayDtoTest extends TestCase
{
	#[ArrayDto(['name' => 'string', 'age' => 'integer', 'average' => 'float', 'approved' => 'bool'])]
	private array $user;

    public function test_deve_validar_que_o_array_nao_possui_os_indices_definidos(): void
    {
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage(
			'Invalid DTO Schema: Expected structure ["name","age","average","approved"] but received ["nome","idade","media","aprovado"]'
		);

		$this->user = ['nome' => 'Deyvid Duarte', 'idade' => 29, 'media' => 12, 'aprovado' => true];
		ArrayDtoHandler::validateSchema($this);
    }

	public function test_deve_validar_que_o_array_nao_esta_com_os_tipos_corretos(): void
    {
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage(
			'Invalid DTO Schema: Expected structure {"name":"string","age":"integer","average":"float","approved":"bool"} but received {"name":"integer","age":"string","average":"integer","approved":"string"}'
		);

		$this->user = ['name' => 29, 'age' => 'teste', 'average' => 12, 'approved' => 'true'];
		ArrayDtoHandler::validateSchema($this);
    }
}
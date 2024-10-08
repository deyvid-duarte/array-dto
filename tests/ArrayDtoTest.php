<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use DeyvidDuarte\{ArrayDto, ArrayDtoHandler};

class TestClass {}

final class ArrayDtoTest extends TestCase
{
	#[ArrayDto([
		'name' => 'string', 
		'age' => 'integer',
		'average' => 'float',
		'approved' => 'bool',
		'teacher' => stdClass::class,
		'class' => TestClass::class,
		'callable' => 'callable'
	])]
	private array $user;

    public function test_deve_validar_que_o_array_nao_possui_os_indices_definidos(): void
    {
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage(
			'Invalid DTO Schema: Expected structure ["name","age","average","approved","teacher","class","callable"] but received ["nome","idade","media","aprovado","professor","classe","callables"]'
		);

		$this->user = [
			'nome' => 'Deyvid Duarte',
			'idade' => 29,
			'media' => 12,
			'aprovado' => true,
			"professor" => '2123123',
			"classe" => false,
			'callables' => 'asdasds'
		];
		ArrayDtoHandler::validateSchema($this);
    }

	public function test_deve_validar_que_o_array_nao_esta_com_os_tipos_corretos(): void
    {
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage(
			'Invalid DTO Schema: Expected structure {"name":"string","age":"integer","average":"float","approved":"bool","teacher":"stdClass","class":"TestClass","callable":"callable"} but received {"name":"integer","age":"string","average":"integer","approved":"string","teacher":"integer","class":"boolean","callable":"string"}'
		);

		$this->user = [
			'name' => 29,
			'age' => 'teste',
			'average' => 12,
			'approved' => 'true',
			'teacher' => 44,
			'class' => false,
			'callable' => 'ola'
		];
		ArrayDtoHandler::validateSchema($this);
    }

	public function test_deve_validar_que_o_array_esta_com_os_tipos_corretos(): void
    {
		$this->user = [
			'name' => 'Deyvid',
			'age' => 29,
			'average' => 10.0,
			'approved' => true,
			'teacher' => new stdClass(),
			'class' => new TestClass(),
			'callable' => function() {
				echo "Olá Mundo!";
			}
		];
		ArrayDtoHandler::validateSchema($this);
		$this->expectNotToPerformAssertions();
    }
}
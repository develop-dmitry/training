<?php

use App\Models\Exceptions\ModelNotFoundException;
use App\Models\Operation;
use PHPUnit\Framework\TestCase;

final class OperationTest extends TestCase
{

    public function testCreate(): void
    {
        $operation = Operation::fromArray([
            'amount' => '5000',
            'description' => 'Тестовое описание',
            'date' => '2022-11-10'
        ]);

        $this->assertEquals('Тестовое описание', $operation->description);
        $this->assertEquals('5000', $operation->amount);
        $this->assertEquals('2022-11-10', $operation->date);
    }

    public function testSave(): void
    {
        $operation = Operation::fromArray([
            'amount' => '6000',
            'description' => 'Тестовое описание',
            'date' => '2022-11-10'
        ]);

        $this->assertEquals(true, $operation->save());

        $id = $operation->id;

        try {
            $operation = Operation::findOrFail($id);
        } catch (ModelNotFoundException) {
            $this->fail('Model don`t inserted in data base');
        }

        $operation->destroy();
    }

    public function testDestroy(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $operation = Operation::fromArray([
            'amount' => '7000',
            'description' => 'Тестовое описание',
            'date' => '2022-11-10'
        ]);

        $this->assertEquals(true, $operation->save());

        $id = $operation->id;

        $this->assertEquals(true, $operation->destroy());

        Operation::findOrFail($id);
    }

    public function testChanged(): void
    {
        $operation = Operation::fromArray([
            'amount' => '8000',
            'description' => 'Тестовое описание',
            'date' => '2022-11-10'
        ]);

        $this->assertEquals('8000', $operation->amount);

        $operation->amount = 10000;

        $this->assertEquals('10000', $operation->amount);
    }

    public function testUpdate(): void
    {
        $operation = Operation::fromArray([
            'amount' => '9000',
            'description' => 'Тестовое описание',
            'date' => '2022-11-10'
        ]);

        $operation->amount = 11000;

        $this->assertEquals(true, $operation->save());

        $id = $operation->id;

        $operation = Operation::find($id);

        $this->assertEquals(11000, $operation->amount);

        $operation->destroy();
    }

    public function testExists(): void
    {
        $operation = Operation::fromArray([
            'amount' => '12000',
            'description' => 'Тестовое описание',
            'date' => '2022-11-10'
        ]);

        $operation->save();

        $this->assertEquals(true, $operation->exists());

        $operation->destroy();
    }
}
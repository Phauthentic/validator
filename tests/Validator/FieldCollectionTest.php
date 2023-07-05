<?php

declare(strict_types=1);

namespace Phauthentic\Test\Validator;

use Phauthentic\Validator\Error\ErrorCollection;
use Phauthentic\Validator\Field\Field;
use Phauthentic\Validator\Field\FieldCollection;
use PHPUnit\Framework\TestCase;

/**
 * FieldCollectionTest
 */
class FieldCollectionTest extends TestCase
{
    public function testMissingFieldException(): void
    {
        $this->expectExceptionMessage('A field with the name `nonExistentField` does not exist in the collection.');
        (new FieldCollection())->get('nonExistentField');
    }

    public function testAddingAFieldThatAlreadyExists()
    {
        $collection = new FieldCollection();
        $this->assertEquals(0, $collection->count());

        $collection->add(new Field('test', new \Phauthentic\Validator\Error\ErrorCollection()));

        $this->expectExceptionMessage('A field with the name `test` already exist in the collection.');
        $collection->add(new Field('test', new ErrorCollection()));
    }

    public function testClearingTheCollection()
    {
        $collection = new FieldCollection();
        $this->assertEquals(0, $collection->count());

        $collection->add(new Field('test', new ErrorCollection()));
        $this->assertEquals(1, $collection->count());

        $collection->clear();
        $this->assertEquals(0, $collection->count());
    }
}

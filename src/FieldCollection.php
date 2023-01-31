<?php

declare(strict_types=1);

namespace Phauthentic\Validator;

use ArrayIterator;
use Phauthentic\Validator\Exception\FieldCollectionException;
use Traversable;

/**
 *
 */
class FieldCollection implements FieldCollectionInterface
{
    /**
     * @var array<string, \Phauthentic\Validator\FieldInterface>
     */
    protected array $fields = [];

    /**
     * @inheritDoc
     */
    public function has(string $fieldName): bool
    {
        return isset($this->fields[$fieldName]);
    }

    /**
     * @inheritDoc
     */
    public function add(FieldInterface $field): void
    {
        $this->assertFieldWithNameExistInCollection($field->getName());
        $this->fields[$field->getName()] = $field;
    }

    protected function assertFieldWithNameExistInCollection(string $fieldName): void
    {
        if ($this->has($fieldName)) {
            throw FieldCollectionException::fieldWithNameExists($fieldName);
        }
    }

    protected function assertFieldWithNameDoesNotExistInCollection(string $fieldName): void
    {
        if (!$this->has($fieldName)) {
            throw FieldCollectionException::fieldWithNameDoesNotExists($fieldName);
        }
    }

    /**
     * @param string $fieldName
     * @return \Phauthentic\Validator\FieldInterface
     * @throws \Phauthentic\Validator\Exception\ValidatorException
     */
    public function get(string $fieldName): FieldInterface
    {
        if (!$this->has($fieldName)) {
            $this->assertFieldWithNameDoesNotExistInCollection($fieldName);
        }

        return $this->fields[$fieldName];
    }

    /**
     * @inheritDoc
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->fields);
    }

    public function clear(): void
    {
        $this->fields = [];
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->fields);
    }
}

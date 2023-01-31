<?php

declare(strict_types=1);

namespace Phauthentic\Validator;

use Countable;
use IteratorAggregate;

/**
 * The description of a field or property of a data element that is validated.
 */
interface FieldCollectionInterface extends IteratorAggregate, Countable
{
    /**
     * Checks if the field of the given name is in the collection.
     *
     * @param string $fieldName
     * @return bool
     */
    public function has(string $fieldName): bool;

    /**
     * Adds a field to the collection.
     *
     * @throws \Phauthentic\Validator\Exception\FieldCollectionException If a field with the given name already exists in the collection.
     *
     * @param \Phauthentic\Validator\FieldInterface $field
     * @return void
     */
    public function add(FieldInterface $field): void;

    /**
     * @param  string $field
     * @return \Phauthentic\Validator\FieldInterface
     * @throws \Phauthentic\Validator\Exception\ValidatorException
     */

    /**
     * Gets a field by its name.
     *
     * @throws \Phauthentic\Validator\Exception\FieldCollectionException If a field with the given name does not exist in the collection.
     *
     * @param string $fieldName
     * @return \Phauthentic\Validator\FieldInterface
     */
    public function get(string $fieldName): FieldInterface;

    /**
     * Removes all fields from the collection.
     *
     * @return void
     */
    public function clear(): void;
}

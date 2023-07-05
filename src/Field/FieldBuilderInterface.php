<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Field;

use Phauthentic\Validator\Rule\RuleDefinitionInterface;

/**
 *
 */
interface FieldBuilderInterface
{
    /**
     * Creates a new builder using the given collection
     *
     * @param \Phauthentic\Validator\Field\FieldCollectionInterface $fieldCollection
     * @return self
     */
    public static function create(FieldCollectionInterface $fieldCollection): self;

    /**
     * @return \Phauthentic\Validator\Field\FieldCollectionInterface
     */
    public function getFieldCollection(): FieldCollectionInterface;

    /**
     * @param string $fieldName The name of the field to be validated.
     * @param string $ruleName The name of the rule you want to apply.
     * @param array<string, mixed> $arguments The arguments passed to the validator method.
     */
    public function add(string $fieldName, string $ruleName, array $arguments = []): RuleDefinitionInterface;
}

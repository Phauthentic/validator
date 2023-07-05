<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Field;

use Phauthentic\Validator\Error\ErrorCollectionInterface;
use Phauthentic\Validator\Rule\RuleDefinitionInterface;

/**
 * Describes a field and how it should be validated in a data set.
 */
interface FieldInterface
{
    /**
     * Returns the field name, used to look up the field in the provided data to
     * fetch the value from it and to validate this value.
     */
    public function getName(): string;

    /**
     * Returns an alias for the fields accessor name if set, if not the name.
     *
     * @return string
     */
    public function getAlias(): string;

    /**
     * Sets an alias for the field name that can be used when generating the
     * error message.
     *
     * @param string $alias
     * @return void
     */
    public function setAlias(string $alias): void;

    /**
     * Returns the rule definitions for this field.
     *
     * @return array<string, \Phauthentic\Validator\Rule\RuleDefinitionInterface>
     */
    public function getRuleDefinitions(): array;

    /**
     * Adds a rule definition.
     *
     * @param \Phauthentic\Validator\Rule\RuleDefinitionInterface $ruleDefinition
     * @return void
     */
    public function addRuleDefinition(RuleDefinitionInterface $ruleDefinition): void;

    /**
     * Removes a rule definition from the field.
     *
     * @param string $ruleName
     * @return void
     */
    public function removeRuleDefinition(string $ruleName): void;

    /**
     * @param string $ruleName
     * @return \Phauthentic\Validator\Rule\RuleDefinitionInterface
     */
    public function getRuleDefinition(string $ruleName): RuleDefinitionInterface;

    /**
     * Checks if the field has any errors.
     *
     * @return bool
     */
    public function hasErrors(): bool;

    /**
     * Returns a collection of errors.
     *
     * @return \Phauthentic\Validator\Error\ErrorCollectionInterface
     */
    public function getErrors(): ErrorCollectionInterface;
}

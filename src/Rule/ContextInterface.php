<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Rule;

use Phauthentic\Validator\Field\FieldInterface;

/**
 * The context object is used to pass data between the otherwise separate
 * elements of the system. The context here is the evaluation of a rule
 * and field, and it's value. All relevant date of this context is present
 * in this object.
 */
interface ContextInterface
{
    /**
     * Gets the whole data that was passed to the validator
     *
     * @return array<mixed, mixed>
     */
    public function getData(): array;

    /**
     * Gets the current value of the field that is being checked.
     *
     * @return mixed
     */
    public function getValue(): mixed;

    /**
     * Gets the field that is being checked.
     */
    public function getField(): FieldInterface;

    /**
     * Gets the rule that is being checked.
     *
     * @return \Phauthentic\Validator\Rule\RuleInterface
     */
    public function getRule(): RuleInterface;
}

<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Error;

use Phauthentic\Validator\Field\FieldInterface;
use Phauthentic\Validator\Rule\RuleInterface;

/**
 *
 */
interface ErrorInterface
{
    /**
     * Returns the field object that has the error.
     *
     * @return \Phauthentic\Validator\Field\FieldInterface
     */
    public function getField(): FieldInterface;

    /**
     * Gets the rule object that caused the validation error.
     *
     * @return \Phauthentic\Validator\Rule\RuleInterface
     */
    public function getRule(): RuleInterface;

    /**
     * Gets the error message.
     *
     * @return string
     */
    public function getMessage(): string;

    /**
     * Sets a message
     *
     * @param string $message
     * @return \Phauthentic\Validator\ErrorInterface
     */
    public function setMessage(string $message): ErrorInterface;
}

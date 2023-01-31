<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Rule;

/**
 *
 */
abstract class AbstractRule implements RuleInterface
{
    protected static string $defaultMessage = '';

    public static function setMessage(string $message): void
    {
        static::$defaultMessage = $message;
    }

    public function getMessage(): string
    {
        return static::$defaultMessage;
    }
}

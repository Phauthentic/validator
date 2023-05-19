<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Rule;

use Phauthentic\Validator\Exception\RuleException;

/**
 *
 */
abstract class AbstractRule implements RuleInterface
{
    /**
     * @var array<mixed, mixed>
     */
    protected array $requiredArguments = [];

    protected static string $defaultMessage = '';

    public static function setMessage(string $message): void
    {
        static::$defaultMessage = $message;
    }

    public function getMessage(): string
    {
        return static::$defaultMessage;
    }

    public function assertArgumentExists(string $argumentName, ArgumentCollectionInterface $attributeCollection): void
    {
        if (!$attributeCollection->has($argumentName)) {
            throw RuleException::requiredArgumentIsMissing(
                $argumentName,
                self::class
            );
        }
    }

    protected function checkRequiredArguments(ArgumentCollectionInterface $argumentCollection): void
    {
        foreach ($this->requiredArguments as $argumentName => $type) {
            if (is_int($argumentName)) {
                $argumentName = $type;
            }

            $this->assertArgumentExists($argumentName, $argumentCollection);
        }
    }
}

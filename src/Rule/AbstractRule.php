<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Rule;

use Phauthentic\Validator\Exception\ValidatorException;

/**
 *
 */
abstract class AbstractRule implements RuleInterface
{
    /**
     * @var array<string, mixed>
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
            throw new ValidatorException(sprintf(
                'The required argument `%s` is not present for rule `%s`.',
                $argumentName,
                self::class
            ));
        }
    }

    protected function checkRequiredArguments(ArgumentCollectionInterface $attributeCollection): void
    {
        foreach ($this->requiredArguments as $argumentName => $type) {
            $this->assertArgumentExists($argumentName, $attributeCollection);
        }
    }
}

<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Rule;

/**
 *
 */
class Between implements RuleInterface
{
    public const NAME = 'between';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return static::NAME;
    }

    /**
     * @inheritDoc
     */
    public function getMessage(): string
    {
        return 'The value {{value}} for the field {{fieldName}} is not between {{min}} and {{max}}';
    }

    public function validate(mixed $value, int|float $min, int|float $max): bool
    {
        if (!is_numeric($value)) {
            return false;
        }

        return ($value >= $min && $value <= $max);
    }
}

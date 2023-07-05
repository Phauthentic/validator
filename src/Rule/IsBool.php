<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Rule;

/**
 *
 */
class IsBool implements RuleInterface
{
    public const NAME = 'isBool';

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
        return 'rule.isBool';
    }

    public function validate(
        mixed $value,
        ArgumentCollectionInterface $arguments,
        ContextInterface $context
    ): bool {
        if (is_string($value)) {
            return $value === 'true' || $value === 'false';
        }

        if (is_int($value)) {
            return $value === 1 || $value === 0;
        }

        return is_bool($value);
    }
}

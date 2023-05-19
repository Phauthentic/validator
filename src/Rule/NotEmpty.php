<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Rule;

/**
 *
 */
class NotEmpty extends AbstractRule
{
    public const NAME = 'notEmpty';
    protected static string $defaultMessage = 'rule.notEmpty.default';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return static::NAME;
    }

    public function validate(
        mixed $value,
        ArgumentCollectionInterface $arguments,
        ContextInterface $context
    ): bool {
        return !empty($value);
    }
}

<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Rule;

/**
 *
 */
class Email extends AbstractRule
{
    public const NAME = 'email';

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
        return 'rule.email.default';
    }

    public function validate(
        mixed $value,
        ArgumentCollectionInterface $arguments,
        ContextInterface $context
    ): bool {
        return filter_var($value, FILTER_VALIDATE_EMAIL)
            && preg_match('/@.+\./', $value);
    }
}

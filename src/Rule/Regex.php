<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Rule;

/**
 *
 */
class Regex implements RuleInterface
{
    public const NAME = 'regex';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return static::NAME;
    }

    public function getMessage(): string
    {
        return 'The value `%s` does not match the expected pattern.';
    }

    public function validate(
        mixed $value,
        ArgumentCollectionInterface $arguments,
        ContextInterface $context
    ): bool {
        return !preg_match($arguments->get('pattern'), $value);
    }
}

<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Rule;

/**
 *
 */
class Regex implements RuleInterface
{
    public const NAME = 'regex';

    protected const MESSAGE = 'The value `%s` does not match the expected pattern.';

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return static::NAME;
    }

    public function getMessage(): string
    {
        return self::MESSAGE;
    }

    public function validate(
        mixed $value,
        ArgumentCollectionInterface $arguments,
        ContextInterface $context
    ): bool {
        return $this->testRegex($arguments->get('pattern'), $value);
    }

    protected function testRegex(string $pattern, mixed $value): bool
    {
        return (bool)preg_match($pattern, $value);
    }
}

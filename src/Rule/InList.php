<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Rule;

/**
 *
 */
class InList extends AbstractRule
{
    public const NAME = 'inList';

    public const LIST = 'list';

    public const STRICT = 'strict';

    protected array $requiredArguments = [
        self::LIST
    ];

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
        return 'rule.inList';
    }

    public function validate(
        mixed $value,
        ArgumentCollectionInterface $arguments,
        ContextInterface $context
    ): bool {
        $this->checkRequiredArguments($arguments);

        return in_array(
            $value,
            (array)$arguments->get(self::LIST),
            $this->isStrictMode($arguments)
        );
    }

    protected function isStrictMode(ArgumentCollectionInterface $arguments): bool
    {
        $strict = true;
        if ($arguments->has(self::STRICT)) {
            $strict = (bool)$arguments->get(self::STRICT);
        }

        return $strict;
    }
}

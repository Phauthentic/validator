<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Rule;

/**
 *
 */
class Between extends AbstractRule
{
    public const NAME = 'between';

    public const MIN = 'min';
    public const MAX = 'max';

    protected array $requiredArguments = [
        self::MAX,
        self::MIN,
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
        return 'The value {{value}} for the field {{fieldName}} is not between {{min}} and {{max}}';
    }

    public function validate(
        mixed $value,
        ArgumentCollectionInterface $arguments,
        ContextInterface $context
    ): bool {
        $this->checkRequiredArguments($arguments);

        $min = $arguments->get(self::MIN);
        $max = $arguments->get(self::MAX);

        return $value >= $min && $value <= $max;
    }
}

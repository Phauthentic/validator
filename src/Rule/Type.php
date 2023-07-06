<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Rule;

/**
 *
 */
class Type extends AbstractRule
{
    public const NAME = 'type';

    protected const MESSAGE = 'rule.type.default';

    protected array $requiredArguments = [
        'type'
    ];

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
        $this->checkRequiredArguments($arguments);

        $type = $arguments->get('type');
        if (is_string($type)) {
            $type = [$type];
        }

        return in_array(gettype($value), $type, true);
    }
}

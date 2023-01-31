<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Rule;

use Phauthentic\Validator\FieldInterface;

/**
 * @inheritDoc
 */
class Context implements ContextInterface
{
    /**
     * @param mixed $value
     * @param array<mixed, mixed> $data
     * @param \Phauthentic\Validator\FieldInterface $field
     * @param \Phauthentic\Validator\Rule\RuleInterface $rule
     */
    public function __construct(
        protected mixed $value,
        protected array $data,
        protected FieldInterface $field,
        protected RuleInterface $rule,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @inheritDoc
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function getField(): FieldInterface
    {
        return $this->field;
    }

    /**
     * @inheritDoc
     */
    public function getRule(): RuleInterface
    {
        return $this->rule;
    }
}

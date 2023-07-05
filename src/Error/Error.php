<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Error;

use Phauthentic\Validator\Field\FieldInterface;
use Phauthentic\Validator\Rule\RuleInterface;

/**
 *
 */
class Error implements ErrorInterface
{
    public function __construct(
        protected FieldInterface $field,
        protected RuleInterface $rule,
        protected string $message
    ) {
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

    /**
     * @inheritDoc
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @inheritDoc
     */
    public function setMessage(string $message): ErrorInterface
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'fieldName' => $this->field->getName(),
            'ruleName' => $this->rule->getName(),
            'message' => $this->message
        ];
    }
}

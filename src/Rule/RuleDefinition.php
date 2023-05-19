<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Rule;

/**
 * A rule description is a data transfer object that is used to describe a rule
 * and how it should be built.
 *
 * It also contains an optional validation message that can be used to override
 * the one provided by the actual rule.
 */
class RuleDefinition implements RuleDefinitionInterface
{
    protected ?string $message = null;

    /**
     * @param string $ruleName
     * @param \Phauthentic\Validator\Rule\ArgumentCollectionInterface $arguments
     */
    public function __construct(
        protected string $ruleName,
        protected ArgumentCollectionInterface $arguments
    ) {
    }

    /**
     * @inheritDoc
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @inheritDoc
     */
    public function getArguments(): ArgumentCollectionInterface
    {
        return $this->arguments;
    }

    /**
     * @inheritDoc
     */
    public function getRuleName(): string
    {
        return $this->ruleName;
    }
}

<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Rule;

/**
 * A rule description is a data transfer object that is used to describe a rule
 * and how it should be built and also contains its validation message.
 */
interface RuleDefinitionInterface
{
    /**
     * @param string $message
     * @return \Phauthentic\Validator\Rule\RuleDefinitionInterface
     */
    public function setMessage(string $message): RuleDefinitionInterface;

    /**
     * @return string|null
     */
    public function getMessage(): ?string;

    /**
     * @return array <string, mixed>
     */
    public function getArguments(): array;

    /**
     * @return string
     */
    public function getRuleName(): string;
}

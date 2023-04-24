<?php

declare(strict_types=1);

namespace Phauthentic\Validator;

use Phauthentic\Validator\Rule\ContextInterface;
use Phauthentic\Validator\Rule\RuleCollectionInterface;

/**
 *
 */
interface ValidatorFactoryInterface
{
    public function createRuleCollection(): RuleCollectionInterface;

    public function createFieldBuilder(): FieldBuilderInterface;

    public function createErrorCollection(): ErrorCollectionInterface;

    public function createFieldCollection(): FieldCollectionInterface;

    public function createValidator(): ValidatorInterface;

    public function createField(string $name): FieldInterface;

    /**
     * @param array<string, mixed> $context
     * @return \Phauthentic\Validator\Rule\ContextInterface
     */
    public function createContextFromArray(array $context): ContextInterface;

    /**
     * @param array<string, mixed> $error
     * @return \Phauthentic\Validator\ErrorInterface
     */
    public function createErrorFromArray(array $error): ErrorInterface;
}

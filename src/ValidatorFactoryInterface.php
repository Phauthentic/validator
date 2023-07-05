<?php

declare(strict_types=1);

namespace Phauthentic\Validator;

use Phauthentic\Validator\Error\ErrorCollectionInterface;
use Phauthentic\Validator\Error\ErrorInterface;
use Phauthentic\Validator\Field\FieldBuilderInterface;
use Phauthentic\Validator\Field\FieldCollectionInterface;
use Phauthentic\Validator\Field\FieldInterface;
use Phauthentic\Validator\Rule\ArgumentCollectionInterface;
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
     * @return \Phauthentic\Validator\Error\ErrorInterface
     */
    public function createErrorFromArray(array $error): ErrorInterface;

    /**
     * @param array<string, mixed> $arguments
     * @return \Phauthentic\Validator\Rule\ArgumentCollectionInterface
     */
    public function createArgumentCollectionFromArray(array $arguments): ArgumentCollectionInterface;
}

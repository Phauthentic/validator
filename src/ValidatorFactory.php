<?php

declare(strict_types=1);

namespace Phauthentic\Validator;

use Phauthentic\Validator\Rule\ArgumentCollection;
use Phauthentic\Validator\Rule\ArgumentCollectionInterface;
use Phauthentic\Validator\Rule\Between;
use Phauthentic\Validator\Rule\Context;
use Phauthentic\Validator\Rule\ContextInterface;
use Phauthentic\Validator\Rule\NotEmpty;
use Phauthentic\Validator\Rule\RuleCollection;
use Phauthentic\Validator\Rule\RuleCollectionInterface;

/**
 *
 */
class ValidatorFactory implements ValidatorFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function createContextFromArray(array $context): ContextInterface
    {
        return new Context(...$context);
    }

    /**
     * @inheritDoc
     */
    public function createErrorFromArray(array $error): ErrorInterface
    {
        return new Error(...$error);
    }

    public function createRuleCollection(): RuleCollectionInterface
    {
        return new RuleCollection(
            [
                new Between(),
                new NotEmpty()
            ]
        );
    }

    public function createFieldBuilder(): FieldBuilderInterface
    {
        return new FieldBuilder(
            $this->createFieldCollection()
        );
    }

    public function createErrorCollection(): ErrorCollectionInterface
    {
        return new ErrorCollection();
    }

    public function createFieldCollection(): FieldCollectionInterface
    {
        return new FieldCollection();
    }

    public function createValidator(): ValidatorInterface
    {
        return new Validator(
            $this->createFieldCollection(),
            $this->createRuleCollection(),
            $this->createErrorCollection(),
            $this->createMessageFormatter()
        );
    }

    public function createMessageFormatter(): MessageFormatterInterface
    {
        return new GlossaryMessageFormatter();
    }

    public function createField(string $name): FieldInterface
    {
        return new Field($name, $this->createErrorCollection());
    }

    public function createArgumentCollectionFromArray(array $arguments): ArgumentCollectionInterface
    {
        return ArgumentCollection::fromArray($arguments);
    }
}

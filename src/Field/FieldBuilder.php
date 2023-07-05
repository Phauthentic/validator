<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Field;

use Phauthentic\Validator\Error\ErrorCollection;
use Phauthentic\Validator\Rule\ArgumentCollection;
use Phauthentic\Validator\Rule\RuleDefinition;
use Phauthentic\Validator\Rule\RuleDefinitionInterface;

/**
 * A helper class to easily build a collection of fields with rule descriptions.
 */
class FieldBuilder implements FieldBuilderInterface
{
    public function __construct(
        protected FieldCollectionInterface $fieldCollection
    ) {
    }

    /**
     * @inheritDoc
     */
    public static function create(FieldCollectionInterface $fieldCollection): self
    {
        return new self($fieldCollection);
    }

    /**
     * @param \Phauthentic\Validator\Field\FieldCollectionInterface $fieldCollection
     * @return \Phauthentic\Validator\FieldBuilder
     */
    public function withFieldCollection(FieldCollectionInterface $fieldCollection): self
    {
        $that = clone $this;
        $that->fieldCollection = $fieldCollection;

        return $that;
    }

    /**
     * @param string $fieldName
     * @return \Phauthentic\Validator\Field\FieldInterface
     */
    protected function createField(string $fieldName): FieldInterface
    {
        return new Field($fieldName, new ErrorCollection());
    }

    /**
     * @param string $ruleName
     * @param array<string, mixed> $arguments
     * @return \Phauthentic\Validator\Rule\RuleDefinitionInterface
     */
    protected function createRuleDefinition(string $ruleName, array $arguments): RuleDefinitionInterface
    {
        return new RuleDefinition(
            $ruleName,
            ArgumentCollection::fromArray($arguments)
        );
    }

    /**
     * @throws \Phauthentic\Validator\Exception\FieldCollectionException|\Phauthentic\Validator\Exception\ValidatorException
     */
    protected function resolveField(string $fieldName): FieldInterface
    {
        if ($this->fieldCollection->has($fieldName)) {
            return $this->fieldCollection->get($fieldName);
        }

        $field = $this->createField($fieldName);
        $this->fieldCollection->add($field);

        return $field;
    }

    /**
     * {{@inheritDoc}}
     * @throws \Phauthentic\Validator\Exception\FieldCollectionException|\Phauthentic\Validator\Exception\ValidatorException
     */
    public function add(string $fieldName, string $ruleName, array $arguments = []): RuleDefinitionInterface
    {
        $field = $this->resolveField($fieldName);

        $ruleDefinition = $this->createRuleDefinition($ruleName, $arguments);
        $field->addRuleDefinition($ruleDefinition);

        return $ruleDefinition;
    }

    /**
     * @param string $fieldName
     * @param array<string, array<string, mixed>> $rules
     * @return \Phauthentic\Validator\Field\FieldBuilderInterface
     * @throws \Phauthentic\Validator\Exception\FieldCollectionException
     * @throws \Phauthentic\Validator\Exception\ValidatorException
     */
    public function addWithManyRules(string $fieldName, array $rules): FieldBuilderInterface
    {
        foreach ($rules as $ruleName => $ruleArguments) {
            $this->add($fieldName, $ruleName, $ruleArguments);
        }

        return $this;
    }

    /**
     * @param string $field
     * @return \Phauthentic\Validator\Rule\RuleDefinitionInterface
     * @throws \Phauthentic\Validator\Exception\FieldCollectionException|\Phauthentic\Validator\Exception\ValidatorException
     */
    public function notEmpty(string $field): RuleDefinitionInterface
    {
        return $this->add($field, 'notEmpty');
    }

    /**
     * @param string $field
     * @param int|float $start
     * @param int|float $end
     * @return \Phauthentic\Validator\Rule\RuleDefinitionInterface
     * @throws \Phauthentic\Validator\Exception\FieldCollectionException|\Phauthentic\Validator\Exception\ValidatorException
     */
    public function between(string $field, int|float $start, int|float $end): RuleDefinitionInterface
    {
        return $this->add($field, 'between', [
            'start' => $start,
            'end' => $end
        ]);
    }

    /**
     * @param string $field
     * @param int $maxLength
     * @return \Phauthentic\Validator\Rule\RuleDefinitionInterface
     * @throws \Phauthentic\Validator\Exception\FieldCollectionException|\Phauthentic\Validator\Exception\ValidatorException
     */
    public function maxLength(string $field, int $maxLength): RuleDefinitionInterface
    {
        return $this->add($field, 'maxLength', [
            'maxLength' => $maxLength
        ]);
    }

    /**
     * @param string $field
     * @param int $minLength
     * @return \Phauthentic\Validator\Rule\RuleDefinitionInterface
     * @throws \Phauthentic\Validator\Exception\FieldCollectionException|\Phauthentic\Validator\Exception\ValidatorException
     */
    public function minLength(string $field, int $minLength): RuleDefinitionInterface
    {
        return $this->add($field, 'minLength', [
            'minLength' => $minLength
        ]);
    }

    /**
     * @param string $field
     * @param string $operator
     * @param int|float $value
     * @return \Phauthentic\Validator\Rule\RuleDefinitionInterface
     * @throws \Phauthentic\Validator\Exception\FieldCollectionException|\Phauthentic\Validator\Exception\ValidatorException
     */
    public function comparison(string $field, string $operator, int|float $value): RuleDefinitionInterface
    {
        return $this->add($field, 'comparison', [
            'operator' => $operator,
            'value' => $value
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getFieldCollection(): FieldCollectionInterface
    {
        return $this->fieldCollection;
    }

    /**
     * @param string $name
     * @param array<int, mixed> $arguments
     * @return mixed
     * @throws \Phauthentic\Validator\Exception\FieldCollectionException
     * @throws \Phauthentic\Validator\Exception\ValidatorException
     */
    public function __call(string $name, array $arguments): mixed
    {
        if ($this->argumentsMatchExpectationForAdd($arguments)) {
            return $this->add($arguments[0], $name, $arguments[1]);
        }

        return null;
    }

    /**
     * @param array<int, mixed> $arguments
     *
     * @return bool
     */
    protected function argumentsMatchExpectationForAdd(array $arguments): bool
    {
        return count($arguments) === 2
            && is_string($arguments[0])
            && is_array($arguments[1]);
    }
}

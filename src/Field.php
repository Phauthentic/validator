<?php

declare(strict_types=1);

namespace Phauthentic\Validator;

use Phauthentic\Validator\Exception\FieldException;
use Phauthentic\Validator\Exception\RuleDefinitionExistsException;
use Phauthentic\Validator\Rule\RuleDefinitionInterface;

/**
 * @inheritDoc
 */
class Field implements FieldInterface
{
    /**
     * @var array<string, \Phauthentic\Validator\Rule\RuleDefinitionInterface>
     */
    public array $ruleDefinitions = [];

    protected ?string $alias = null;

    /**
     * @param string $fieldName
     * @param \Phauthentic\Validator\ErrorCollectionInterface $errorCollection
     * @param array<string, \Phauthentic\Validator\Rule\RuleDefinitionInterface> $ruleDefinitions
     */
    public function __construct(
        protected string $fieldName,
        protected ErrorCollectionInterface $errorCollection,
        array $ruleDefinitions = []
    ) {
        foreach ($ruleDefinitions as $ruleDefinition) {
            $this->addRuleDefinition($ruleDefinition);
        }
    }

    protected function assertRuleDefinitionDoesNotExistForField(RuleDefinitionInterface $ruleDefinition): void
    {
        if (isset($this->ruleDefinitions[$ruleDefinition->getRuleName()])) {
            throw RuleDefinitionExistsException::forField(
                $this->getName(),
                $ruleDefinition->getRuleName()
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function removeRuleDefinition(string $ruleName): void
    {
        unset($this->ruleDefinitions[$ruleName]);
    }

    /**
     * @inheritDoc
     */
    public function addRuleDefinition(RuleDefinitionInterface $ruleDefinition): void
    {
        $this->assertRuleDefinitionDoesNotExistForField($ruleDefinition);

        $this->ruleDefinitions[$ruleDefinition->getRuleName()] = $ruleDefinition;
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return $this->fieldName;
    }

    /**
     * @inheritDoc
     */
    public function setAlias(string $alias): void
    {
        $this->alias = $alias;
    }

    public function getAlias(): string
    {
        if ($this->alias) {
            return $this->alias;
        }

        return $this->fieldName;
    }

    /**
     * @param string $ruleName
     * @return \Phauthentic\Validator\Rule\RuleDefinitionInterface
     * @throws \Phauthentic\Validator\Exception\FieldException
     */
    public function getRuleDefinition(string $ruleName): RuleDefinitionInterface
    {
        if (!isset($this->ruleDefinitions[$ruleName])) {
            throw FieldException::isMissingRuleDefinition($ruleName, $this->getName());
        }

        return $this->ruleDefinitions[$ruleName];
    }

    /**
     * @inheritDoc
     */
    public function getRuleDefinitions(): array
    {
        return $this->ruleDefinitions;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'fieldName' => $this->fieldName
        ];
    }

    public function hasErrors(): bool
    {
        return $this->errorCollection->count() > 0;
    }

    public function getErrors(): ErrorCollectionInterface
    {
        return $this->errorCollection;
    }
}

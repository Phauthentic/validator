<?php

declare(strict_types=1);

namespace Phauthentic\Validator;

use Phauthentic\Validator\MessageFormatter\MessageFormatterInterface;
use Phauthentic\Validator\Rule\Context;
use Phauthentic\Validator\Rule\ContextInterface;
use Phauthentic\Validator\Rule\RuleCollectionInterface;
use Phauthentic\Validator\Rule\RuleDefinitionInterface;
use Phauthentic\Validator\Utility\ArrayHelper;

/**
 * The Validator is kind of a facade that brings everything the library has to
 * offer together: It will operate on a collection of fields and validate them
 * by the rule definitions attached to them.
 *
 * A validator can optionally provide a rule builder to conveniently build
 * rules for fields on the fly.
 */
class Validator implements ValidatorInterface
{
    /**
     * @var array<mixed, mixed>
     */
    protected array $inputs = [];

    public function __construct(
        protected FieldCollectionInterface $fieldCollection,
        protected RuleCollectionInterface $ruleCollection,
        protected ErrorCollectionInterface $errorCollection,
        protected MessageFormatterInterface $messageFormatter,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function validate(array $inputs): ResultInterface
    {
        $this->inputs = $inputs;
        $this->errorCollection->clear();

        foreach ($this->fieldCollection as $field) {
            $this->validateField($field);
        }

        return $this->createResult(
            isValid: $this->errorCollection->count() === 0,
            errorCollection: $this->errorCollection
        );
    }

    /**
     * @param bool $isValid
     * @param \Phauthentic\Validator\ErrorCollectionInterface $errorCollection
     * @return \Phauthentic\Validator\ResultInterface
     */
    protected function createResult(
        bool $isValid,
        ErrorCollectionInterface $errorCollection
    ): ResultInterface {
        return Result::create(
            isValid: $isValid,
            errorCollection: $errorCollection
        );
    }

    /**
     * @param \Phauthentic\Validator\FieldInterface $field
     * @return void
     */
    protected function validateField(FieldInterface $field): void
    {
        if ($this->isArrayField($field->getName())) {
            $fields = $this->parseArrayField($this->inputs, $field);
            foreach ($fields as $nestedField) {
                $this->validateField($nestedField);
            }

            return;
        }

        $value = ArrayHelper::arrayGet($this->inputs, $field->getName());
        foreach ($field->getRuleDefinitions() as $ruleDefinition) {
            $this->applyRule($ruleDefinition, $value, $field);
        }
    }

    /**
     * @param array<string, mixed> $context
     * @return \Phauthentic\Validator\Rule\ContextInterface
     */
    protected function createContext(array $context): ContextInterface
    {
        return new Context(...$context);
    }

    /**
     * @param array<string, mixed> $error
     * @return \Phauthentic\Validator\ErrorInterface
     */
    protected function createError(array $error): ErrorInterface
    {
        return new Error(...$error);
    }

    /**
     * @param \Phauthentic\Validator\Rule\RuleDefinitionInterface $ruleDefinition
     * @param mixed $value
     * @param \Phauthentic\Validator\FieldInterface $field
     * @return void
     */
    protected function applyRule(
        RuleDefinitionInterface $ruleDefinition,
        mixed $value,
        FieldInterface $field,
    ): void {
        $rule = $this->ruleCollection->get($ruleDefinition->getRuleName());
        $arguments = $ruleDefinition->getArguments();
        $context = $this->createContext([
            'value' => $value,
            'data' => $this->inputs,
            'field' => $field,
            'rule' => $rule,
        ]);

        if (!$rule->validate($value, $arguments, $context)) {
            $error = $this->createError([
                'field' => $field,
                'rule' => $rule,
                'message' => $this->messageFormatter->formatMessage($context)
            ]);

            $field->getErrors()->add($error);
            $this->errorCollection->add($error);
        }
    }

    /**
     * @param array<mixed, mixed> $data
     * @param string $attributeKey
     * @return array<int, string>
     */
    protected function extractValuesForWildcards(array $data, string $attributeKey): array
    {
        $pattern = str_replace('\*', '[^\.]+', preg_quote($attributeKey, null));

        $keys = [];
        foreach ($data as $key => $value) {
            if (preg_match('/^' . $pattern . '/', (string)$key, $matches)) {
                $keys[] = $matches[0];
            }
        }

        return $keys;
    }

    /**
     * @param string $key
     * @return bool
     */
    protected function isArrayField(string $key): bool
    {
        return str_contains($key, '*');
    }

    /**
     * @param array<mixed, mixed> $data
     * @param \Phauthentic\Validator\FieldInterface $field
     * @return array<int, \Phauthentic\Validator\FieldInterface>
     */
    protected function parseArrayField(array $data, FieldInterface $field): array
    {
        $fieldKey = $field->getName();
        $data = ArrayHelper::arrayDot($this->initializeFieldOnData($data, $fieldKey));
        $pattern = str_replace('\*', '([^\.]+)', preg_quote($fieldKey, null));

        $data = array_merge($data, $this->extractValuesForWildcards(
            $data,
            $fieldKey
        ));

        $fields = [];

        foreach ($data as $key => $value) {
            if (!is_string($key)) {
                $key = (string)$key;
            }

            if (preg_match('/^' . $pattern . '\z/', $key, $match)) {
                $newField = new Field($key, new ErrorCollection(), $field->getRuleDefinitions());

                $fields[] = $newField;
            }
        }

        return $fields;
    }

    protected function getLeadingExplicitAttributePath(string $attributeKey): ?string
    {
        return rtrim(explode('*', $attributeKey)[0], '.') ?: null;
    }

    /**
     * @param array<mixed, mixed> $data
     * @param string $attributeKey
     * @return array<mixed, mixed>
     */
    protected function initializeFieldOnData(array $data, string $attributeKey): array
    {
        $explicitPath = $this->getLeadingExplicitAttributePath($attributeKey);
        $otherData = $this->extractDataFromPath($data, $explicitPath);
        $asteriskPos = strpos($attributeKey, '*');

        if (false === $asteriskPos || $asteriskPos === (mb_strlen($attributeKey, 'UTF-8') - 1)) {
            return $data;
        }

        return ArrayHelper::arraySet($otherData, $attributeKey, null);
    }

    /**
     * @param array<mixed, mixed> $data
     * @param null|string $attributeKey
     * @return array<mixed, mixed>
     */
    protected function extractDataFromPath(array $data, ?string $attributeKey): array
    {
        $results = [];
        $value = ArrayHelper::arrayGet($data, $attributeKey, '__missing__');

        if ($value !== '__missing__') {
            ArrayHelper::arraySet($results, $attributeKey, $value);
        }

        return $results;
    }
}

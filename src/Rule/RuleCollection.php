<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Rule;

use Phauthentic\Validator\Exception\RuleCollectionException;

/**
 *
 */
class RuleCollection implements RuleCollectionInterface
{
    /**
     * @var array<string, \Phauthentic\Validator\Rule\RuleInterface>
     */
    protected array $rules = [];

    /**
     * @param  array<int, \Phauthentic\Validator\Rule\RuleInterface> $rules
     * @throws \Phauthentic\Validator\Exception\ValidatorException
     */
    public function __construct(array $rules = [])
    {
        foreach ($rules as $rule) {
            $this->add($rule);
        }
    }

    /**
     * @inheritDoc
     */
    public function add(RuleInterface $rule): void
    {
        if (isset($this->rules[$rule->getName()])) {
            throw RuleCollectionException::ruleWithNameExists($rule->getName());
        }

        $this->rules[$rule->getName()] = $rule;
    }

    /**
     * @inheritDoc
     */
    public function has(string $ruleName): bool
    {
        return isset($this->rules[$ruleName]);
    }

    /**
     * @inheritDoc
     */
    public function get(string $ruleName): RuleInterface
    {
        if (!$this->has($ruleName)) {
            throw RuleCollectionException::ruleWithNameDoesNotExists($ruleName);
        }

        return $this->rules[$ruleName];
    }
}

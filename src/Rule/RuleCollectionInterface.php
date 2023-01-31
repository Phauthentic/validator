<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Rule;

/**
 *
 */
interface RuleCollectionInterface
{
    /**
     * @param \Phauthentic\Validator\Rule\RuleInterface $rule
     * @return void
     */
    public function add(RuleInterface $rule): void;

    /**
     * @param string $ruleName
     * @return bool
     */
    public function has(string $ruleName): bool;

    /**
     * @param string $ruleName
     * @return \Phauthentic\Validator\Rule\RuleInterface
     */
    public function get(string $ruleName): RuleInterface;
}

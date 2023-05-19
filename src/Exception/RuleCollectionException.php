<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Exception;

/**
 *
 */
class RuleCollectionException extends ValidatorException
{
    /**
     * @param string $ruleName
     * @return self
     */
    public static function ruleWithNameExists(string $ruleName): self
    {
        return new self(sprintf(
            'A rule with the name `%s` already exist in the collection.',
            $ruleName,
        ));
    }

    /**
     * @param string $ruleName
     * @return self
     */
    public static function ruleWithNameDoesNotExists(string $ruleName): self
    {
        return new self(sprintf(
            'A rule with the name `%s` does not exist in the collection.',
            $ruleName,
        ));
    }
}

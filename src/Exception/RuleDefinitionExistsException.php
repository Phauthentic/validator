<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Exception;

/**
 *
 */
class RuleDefinitionExistsException extends ValidatorException
{
    /**
     * @param string $fieldName
     * @param string $ruleName
     * @return self
     */
    public static function forField(string $fieldName, string $ruleName): self
    {
        return new self(sprintf(
            'A definition for the rule `%s` already exists for the field `%s`.',
            $ruleName,
            $fieldName
        ));
    }
}

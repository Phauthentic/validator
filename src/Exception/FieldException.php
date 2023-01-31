<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Exception;

/**
 *
 */
class FieldException extends ValidatorException
{
    /**
     * @param string $fieldName
     * @return self
     */
    public static function isMissingRuleDefinition(string $ruleName, string $fieldName): self
    {
        return new self(sprintf(
            'A rule definition for a rule with the name `%s` is not present for the field `%s`',
            $ruleName,
            $fieldName,
        ));
    }
}

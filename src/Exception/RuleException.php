<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Exception;

/**
 *
 */
class RuleException extends ValidatorException
{
    protected const REQUIRED_ARGUMENT_MISSING_MESSAGE = 'The required argument `%s` is not present for rule `%s`.';

    /**
     * @param string $argument
     * @param string $ruleClassName
     * @return self
     */
    public static function requiredArgumentIsMissing(
        string $argument,
        string $ruleClassName
    ): self {
        return new self(sprintf(
            self::REQUIRED_ARGUMENT_MISSING_MESSAGE,
            $argument,
            $ruleClassName
        ));
    }
}

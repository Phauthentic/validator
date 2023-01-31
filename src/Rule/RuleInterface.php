<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Rule;

use Phauthentic\Validator\ValidationErrorInterface;

/**
 * A rule must implement a **validate** method, but it is not part of the
 * interface because of an intentional design decision to make the methods
 * strict typed. But because of very different rule arguments, this can't be in
 * an interface.
 *
 * Conventions:
 * - A rule validates a value if it matches the expectation of the rule.
 * - A rule MUST be stateless.
 */
interface RuleInterface
{
    /**
     * Gets the name of the rule.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Gets the standard validation message string from this rule.
     *
     * @return string
     */
    public function getMessage(): string;
}

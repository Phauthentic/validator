<?php

declare(strict_types=1);

namespace Phauthentic\Validator;

use Phauthentic\Validator\Rule\ContextInterface;

/**
 * Formats an error message.
 *
 * Set the default message of the rules if you need specific placeholders
 * and implement your own formatter that will read them and apply our own
 * template and translation system via a message formatter.
 */
interface MessageFormatterInterface
{
    /**
     * Formats a validation message based on the context data of the current
     * rule validation.
     *
     * @param  \Phauthentic\Validator\Rule\ContextInterface $context
     * @return string
     */
    public function formatMessage(ContextInterface $context): string;
}

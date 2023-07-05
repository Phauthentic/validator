<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Rule;

/**
 * UUID Validation Rule
 */
class Uuid extends Regex
{
    public const NAME = 'uuid';

    protected const UUID_V4_REGEX = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';

    protected const UUID_V1_AND_V4 = '/^[0-9a-f]{8}-(?:[0-9a-f]{4}-){3}[0-9a-f]{12}$/i';

    protected const MESSAGE = 'The provided value `%s` is not a valid UUID.';

    public function validate(mixed $value, ArgumentCollectionInterface $arguments, ContextInterface $context): bool
    {
        $regex = self::UUID_V1_AND_V4;
        if ($arguments->has('v4')) {
            $regex = self::UUID_V4_REGEX;
        }

        return is_string($value) && preg_match($regex, $value);
    }
}

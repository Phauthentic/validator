<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Rule;

use Countable;
use Phauthentic\Validator\Exception\ValidatorException;

use function count;

/**
 * Count Rule
 */
class Count extends AbstractRule
{
    public const NAME = 'count';

    public const EQUAL = '=';
    public const EQUAL_OR_GREATER_THAN = '>=';
    public const EQUAL_OR_SMALLER_THAN = '<=';
    public const SMALLER_THAN = '<';
    public const GREATER_THAN = '>';

    protected const MESSAGE = 'rule.count.default';

    protected array $requiredArguments = [];

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return static::NAME;
    }

    public function getMessage(): string
    {
        return self::MESSAGE;
    }

    public function validate(
        mixed $value,
        ArgumentCollectionInterface $arguments,
        ContextInterface $context
    ): bool {
        $this->checkRequiredArguments($arguments);

        if (!is_string($value) && !$value instanceof Countable && !is_array($value)) {
            return false;
        }

        $operator = self::EQUAL;
        if ($arguments->has('operator')) {
            $operator = $arguments->get('operator');
        }

        return $this->matchesExpectedCount(
            $this->getCount($value),
            $operator,
            $arguments->get('count')
        );
    }

    /**
     * @param int $count
     * @param string $operator
     * @param int $expectedCount
     * @return bool
     * @throws \Phauthentic\Validator\Exception\ValidatorException
     */
    protected function matchesExpectedCount(int $count, string $operator, int $expectedCount): bool
    {
        return match ($operator) {
            self::EQUAL => $count === $expectedCount,
            self::EQUAL_OR_GREATER_THAN => $count >= $expectedCount,
            self::EQUAL_OR_SMALLER_THAN => $count <= $expectedCount,
            self::GREATER_THAN => $count < $expectedCount,
            self::SMALLER_THAN => $count > $expectedCount,
            default => throw new ValidatorException(sprintf(
                'Invalid operator: %s',
                $operator
            )),
        };
    }

    protected function getCount(mixed $value): int
    {
        if (is_string($value)) {
            return mb_strlen($value);
        }

        return count($value);
    }
}

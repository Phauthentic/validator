<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Error;

use ArrayIterator;
use Traversable;

/**
 *
 */
class ErrorCollection implements ErrorCollectionInterface
{
    /**
     * @var array<string, array<string, \Phauthentic\Validator\Error\ErrorInterface>>
     */
    protected array $errors = [];
    public function add(ErrorInterface $error): void
    {
        $this->errors[$error->getField()->getName()][$error->getRule()->getName()] = $error;
    }

    public function has(string $field): bool
    {
        return !empty($this->errors[$field]);
    }

    public function getError(string $field, string $rule): ?ErrorInterface
    {
        if (!isset($this->errors[$field][$rule])) {
            return null;
        }

        return $this->errors[$field][$rule];
    }

    /**
     * @return array<string, array<string, \Phauthentic\Validator\Error\ErrorInterface>>
     */
    public function toArray(): array
    {
        return $this->errors;
    }

    public function count(): int
    {
        return count($this->errors);
    }

    public function clear(): void
    {
        $this->errors = [];
    }

    /**
     * @inheritDoc
     */
    public function getIterator(): Traversable
    {
        $return = [];
        foreach ($this->errors as $field => $errors) {
            foreach ($errors as $error) {
                $return[] = $error;
            }
        }

        return new ArrayIterator($return);
    }
}

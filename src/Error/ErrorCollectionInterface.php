<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Error;

use Countable;
use IteratorAggregate;
use Traversable;

/**
 * ErrorCollectionInterface
 */
interface ErrorCollectionInterface extends Countable, IteratorAggregate
{
    public function add(ErrorInterface $error): void;
    public function has(string $field): bool;
    public function getError(string $field, string $rule): ?ErrorInterface;

    /**
     * @return array<mixed, mixed>
     */
    public function toArray(): array;
    public function count(): int;
/**
     * @return void
     */
    public function clear(): void;

    /**
     * @inheritDoc
     */
    public function getIterator(): Traversable;
}

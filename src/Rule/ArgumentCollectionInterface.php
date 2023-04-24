<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Rule;

/**
 *
 */
interface ArgumentCollectionInterface
{
    /**
     *
     */
    public function add(string $name, mixed $value): void;

    /**
     * @param array<string, mixed> $attributes
     */
    public function addMany(array $attributes): void;

    /**
     *
     */
    public function has(string $name): bool;

    /**
     * @param string $name
     * @return mixed
     */
    public function get(string $name): mixed;
}

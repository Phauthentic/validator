<?php

declare(strict_types=1);

namespace Phauthentic\Validator;

/**
 *
 */
interface ValidatorInterface
{
    /**
     * Validates the given inputs.
     *
     * @param array<mixed,mixed> $inputs
     */
    public function validate(array $inputs): ResultInterface;
}

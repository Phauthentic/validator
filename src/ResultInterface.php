<?php

declare(strict_types=1);

namespace Phauthentic\Validator;

use Phauthentic\Validator\Error\ErrorCollectionInterface;

/**
 * The validation result.
 */
interface ResultInterface
{
    /**
     * @return bool
     */
    public function isValid(): bool;

    /**
     * @return \Phauthentic\Validator\Error\ErrorCollectionInterface
     */
    public function getErrors(): ErrorCollectionInterface;

    public static function create(bool $isValid, ErrorCollectionInterface $errorCollection): self;
}

<?php

declare(strict_types=1);

namespace Phauthentic\Validator;

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
     * @return \Phauthentic\Validator\ErrorCollectionInterface
     */
    public function getErrors(): ErrorCollectionInterface;

    public static function create(bool $isValid, ErrorCollectionInterface $errorCollection): self;
}

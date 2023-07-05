<?php

declare(strict_types=1);

namespace Phauthentic\Validator;

use Phauthentic\Validator\Error\ErrorCollectionInterface;

/**
 *
 */
class Result implements ResultInterface
{
    public function __construct(
        protected bool $isValid,
        protected ErrorCollectionInterface $errorCollection
    ) {
    }

    public static function create(bool $isValid, ErrorCollectionInterface $errorCollection): self
    {
        return new self($isValid, $errorCollection);
    }

    /**
     * @inheritDoc
     */
    public function isValid(): bool
    {
        return $this->isValid;
    }

    /**
     * @inheritDoc
     */
    public function getErrors(): ErrorCollectionInterface
    {
        return $this->errorCollection;
    }
}

<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Exception;

/**
 *
 */
class FieldCollectionException extends ValidatorException
{
    /**
     * @param string $fieldName
     * @return self
     */
    public static function fieldWithNameExists(string $fieldName): self
    {
        return new self(sprintf(
            'A field with the name `%s` already exist in the collection.',
            $fieldName,
        ));
    }

    /**
     * @param string $fieldName
     * @return self
     */
    public static function fieldWithNameDoesNotExists(string $fieldName): self
    {
        return new self(sprintf(
            'A field with the name `%s` does not exist in the collection.',
            $fieldName,
        ));
    }
}

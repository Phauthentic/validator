<?php

declare(strict_types=1);

namespace Phauthentic\Validator\Rule;

use Phauthentic\Validator\Exception\ValidatorException;

/**
 *
 */
class ArgumentCollection implements ArgumentCollectionInterface
{
    public const TYPE_STRING = 'string';
    public const TYPE_FLOAT = 'float';
    public const TYPE_INTEGER = 'integer';
    public const TYPE_BOOL = 'bool';

    /**
     * @var array<string, \Phauthentic\Validator\Rule\RuleInterface>
     */
    protected array $arguments = [];

    /**
     * @param array<string, mixed> $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->addMany($attributes);
    }

    /**
     * @inheritDoc
     */
    public function add(string $name, mixed $value): void
    {
        $this->arguments[$name] = $value;
    }

    /**
     * @param array<string, mixed> $array
     */
    public static function fromArray(array $array): self
    {
        $that = new self();
        $that->addMany($array);

        return $that;
    }

    /**
     * @inheritDoc
     */
    public function addMany(array $attributes): void
    {
        foreach ($attributes as $name => $value) {
            $this->add($name, $value);
        }
    }

    /**
     * @inheritDoc
     */
    public function has(string $name): bool
    {
        return isset($this->arguments[$name]);
    }

    /**
     * @inheritDoc
     */
    public function get(string $name): mixed
    {
        $this->assertArgumentExists($name);

        return $this->arguments[$name];
    }

    public function assertArgumentExists(string $name): void
    {
        if (!$this->has($name)) {
            throw new ValidatorException(sprintf(
                'Argument `%s` does not exist in the collection.',
                $name
            ));
        }
    }

    public function getAs(string $name, string $type): string|int|null|float|bool
    {
        $value = $this->get($name);
        if ($value === null) {
            return null;
        }

        switch ($type) {
            case static::TYPE_STRING:
                return (string)$value;
            case static::TYPE_FLOAT:
                return (float)$value;
            case static::TYPE_INTEGER:
                return (int)$value;
            case static::TYPE_BOOL:
                return (bool)$value;
        }

        throw new ValidatorException(sprintf(
            'Can\'t cast value to type `%s`.',
            $type
        ));
    }

    public function toArray(): array
    {
        return $this->arguments;
    }
}

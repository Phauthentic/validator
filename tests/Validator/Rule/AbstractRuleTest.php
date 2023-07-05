<?php

declare(strict_types=1);

namespace Phauthentic\Test\Validator\Rule;

use Phauthentic\Validator\Error\ErrorCollection;
use Phauthentic\Validator\Field\Field;
use Phauthentic\Validator\Rule\Context;
use Phauthentic\Validator\Rule\ContextInterface;
use PHPUnit\Framework\TestCase;

/**
 * Validator Test
 */
abstract class AbstractRuleTest extends TestCase
{
    protected function createContext($rule, $value): ContextInterface
    {
        return new Context(
            $value,
            [],
            new Field('test', new ErrorCollection()),
            $rule
        );
    }
}

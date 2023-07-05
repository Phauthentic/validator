<?php

declare(strict_types=1);

namespace Phauthentic\Test\Validator\Rule;

use Phauthentic\Validator\Rule\ArgumentCollection;
use Phauthentic\Validator\Rule\Between;

/**
 * Between Test
 */
class BetweenTest extends AbstractRuleTest
{
    /**
     * @dataProvider provideInputs
     * @param bool $expected
     * @param mixed $value
     * @param mixed $min
     * @param mixed $max
     * @return void
     */
    public function testBetween(bool $expected, mixed $value, mixed $min, mixed $max): void
    {
        $rule = new Between();

        $argumentCollection = new ArgumentCollection([
            Between::MIN => $min,
            Between::MAX => $max
        ]);

        $result = $rule->validate(
            $value,
            $argumentCollection,
            $this->createContext($rule, $value)
        );

        $this->assertEquals($expected, $result);
    }

    public function provideInputs(): array
    {
        return [
            [true, 50, 10, 60],
            [false, 0, 10, 60],
            [false, 70, 10, 60],
            [true, 50.55, 10.1, 75.12],
            [false, 1.11, 10.1, 75.12]
        ];
    }
}

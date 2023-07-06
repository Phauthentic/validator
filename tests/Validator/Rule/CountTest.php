<?php

declare(strict_types=1);

namespace Phauthentic\Test\Validator\Rule;

use Phauthentic\Validator\Rule\ArgumentCollection;
use Phauthentic\Validator\Rule\Count;

/**
 * Count Test
 */
class CountTest extends AbstractRuleTest
{
    /**
     * @dataProvider provideInputValue
     */
    public function testCount($expectedResult, $value): void
    {
        $rule = new Count();

        $result = $rule->validate(
            $value,
            new ArgumentCollection(['count' => 3]),
            $this->createContext($rule, $value)
        );

        $this->assertEquals($expectedResult, $result);
    }

    public function provideInputValue(): array
    {
        return [
            [3, '123'],
            [3, [1,2,3]],
           // [false, 235235]
        ];
    }
}

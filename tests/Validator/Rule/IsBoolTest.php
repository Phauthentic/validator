<?php

declare(strict_types=1);

namespace Phauthentic\Test\Validator\Rule;

use Phauthentic\Validator\Rule\ArgumentCollection;
use Phauthentic\Validator\Rule\IsBool;

/**
 * IsBool Test
 */
class IsBoolTest extends AbstractRuleTest
{
    /**
     * @dataProvider provideInputValue
     */
    public function testIsBool($expectedResult, $value): void
    {
        $rule = new IsBool();

        $result = $rule->validate(
            $value,
            new ArgumentCollection([]),
            $this->createContext($rule, $value)
        );

        $this->assertEquals($expectedResult, $result);
    }

    public function provideInputValue(): array
    {
        return [
            [true, 'true'],
            [true, 'false'],
            [true, true],
            [true, false],
            [true, 1],
            [true, 0]
        ];
    }
}

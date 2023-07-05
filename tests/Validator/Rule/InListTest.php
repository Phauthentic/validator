<?php

declare(strict_types=1);

namespace Phauthentic\Test\Validator\Rule;

use Phauthentic\Validator\Rule\ArgumentCollection;
use Phauthentic\Validator\Rule\InList;

/**
 * IsBool Test
 */
class InListTest extends AbstractRuleTest
{
    /**
     * @dataProvider provideLists
     * @param bool $expected
     * @param mixed $value
     * @param array<mixed, mixed> $list
     * @return void
     */
    public function testInList($expected, $value, $list): void
    {
        $rule = new InList();
        $argumentCollection = new ArgumentCollection(['list' => $list]);

        $result = $rule->validate(
            $value,
            $argumentCollection,
            $this->createContext($rule, $value)
        );

        $this->assertEquals($expected, $result);
    }

    public function provideLists(): array
    {
        return [
            [false, 'no', ['one', 'two']],
            [true, 'one', ['one', 'two']],
            [true, 'two', ['one', 'two']]
        ];
    }
}

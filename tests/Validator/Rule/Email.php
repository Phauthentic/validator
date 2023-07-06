<?php

declare(strict_types=1);

namespace Phauthentic\Test\Validator\Rule;

use Phauthentic\Validator\Rule\ArgumentCollection;
use Phauthentic\Validator\Rule\Email;

/**
 * Email Test
 */
class EmailTest extends AbstractRuleTest
{
    /**
     * @dataProvider provideInputValue
     */
    public function testCount($expectedResult, $value): void
    {
        $rule = new Email();

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
            [true, 'test@test.com'],
            [false, 'abcdefgh'],
        ];
    }
}

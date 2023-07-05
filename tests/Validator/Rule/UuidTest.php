<?php

declare(strict_types=1);

namespace Phauthentic\Test\Validator\Rule;

use Phauthentic\Validator\Rule\ArgumentCollection;
use Phauthentic\Validator\Rule\Uuid;

/**
 * Uuid Test
 */
class UuidTest extends AbstractRuleTest
{
    protected const UUID_V1 = '516b0972-f696-11ed-b67e-0242ac120002';
    protected const UUID_V4 = 'c793a6c2-f93d-4e6e-86ec-2f00a1473f7b';

    public function testUuidV4()
    {
        $rule = new Uuid();

        $result = $rule->validate(
            static::UUID_V4,
            new ArgumentCollection([]),
            $this->createContext($rule, self::UUID_V4)
        );
        $this->assertTrue($result);
    }

    public function testUuidV1()
    {
        $rule = new Uuid();

        $result = $rule->validate(
            static::UUID_V1,
            new ArgumentCollection([]),
            $this->createContext($rule, self::UUID_V1)
        );

        $this->assertTrue($result);
    }
}

<?php

declare(strict_types=1);

namespace Phauthentic\Test\Validator\Rule;

use Phauthentic\Validator\Rule\ArgumentCollection;
use Phauthentic\Validator\Rule\RuleDefinition;

/**
 * Validator Test
 */
class RuleDefinitionTest extends AbstractRuleTest
{
    public function testRuleDefinition(): void
    {
        $argumentCollection = new ArgumentCollection(['one' => 1]);
        $ruleDefinition = new RuleDefinition(
            'name',
            $argumentCollection
        );

        $this->assertEquals('name', $ruleDefinition->getRuleName());
        $this->assertEquals($argumentCollection, $ruleDefinition->getArguments());
        $this->assertEquals('', $ruleDefinition->getMessage());
    }
}

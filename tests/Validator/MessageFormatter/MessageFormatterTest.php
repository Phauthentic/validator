<?php

declare(strict_types=1);

namespace Phauthentic\Test\Validator\MessageFormatter;

use Phauthentic\Validator\Error\ErrorCollection;
use Phauthentic\Validator\Field\Field;
use Phauthentic\Validator\MessageFormatter\GlossaryMessageFormatter;
use Phauthentic\Validator\Rule\ArgumentCollection;
use Phauthentic\Validator\Rule\Between;
use Phauthentic\Validator\Rule\Context;
use Phauthentic\Validator\Rule\RuleDefinition;
use PHPUnit\Framework\TestCase;

/**
 * Validator Test
 */
class MessageFormatterTest extends TestCase
{
    public function testMessageFormatter(): void
    {
        $ruleDefinition = new RuleDefinition(
            Between::NAME,
            ArgumentCollection::fromArray(['min' => 3, 'max' => 10])
        );

        $field = new Field('test', new ErrorCollection());
        $field->addRuleDefinition($ruleDefinition);
        $field->setAlias('level');

        $context = new Context(
            2,
            [],
            $field,
            new Between(),
        );

        $formatter = new GlossaryMessageFormatter();

        $this->assertEquals(
            'The value 2 for the field level is not between 3 and 10',
            $formatter->formatMessage($context)
        );

        $field->getRuleDefinition(Between::NAME)
            ->setMessage('The value {{value}} is not valid!');

        $this->assertEquals(
            'The value 2 is not valid!',
            $formatter->formatMessage($context)
        );
    }
}

<?php

declare(strict_types=1);

namespace Phauthentic\Test\Validator;

use Phauthentic\Validator\FieldBuilder;
use Phauthentic\Validator\FieldCollection;
use PHPUnit\Framework\TestCase;

/**
 * RuleBuilderTest
 */
class FieldBuilderTest extends TestCase
{
    public function testRuleBuilder(): void
    {
        $fieldBuilder = FieldBuilder::create(new FieldCollection());

        $fieldBuilder->add('name', 'notEmpty');
        $fieldBuilder->minLength('project', 3);
        $fieldBuilder->maxLength('project', 10);

        $fieldCollection = $fieldBuilder->getFieldCollection();

        $this->assertCount(2, $fieldCollection);
        $this->assertTrue($fieldCollection->has('name'));
        $this->assertTrue($fieldCollection->has('project'));
        $this->assertEquals(['minLength' => 3], $fieldCollection->get('project')->getRuleDefinition('minLength')->getArguments()->toArray());
        $this->assertEquals(['maxLength' => 10], $fieldCollection->get('project')->getRuleDefinition('maxLength')->getArguments()->toArray());
    }
}

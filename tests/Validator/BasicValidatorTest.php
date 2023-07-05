<?php

declare(strict_types=1);

namespace Phauthentic\Test\Validator;

use Phauthentic\Validator\ErrorCollection;
use Phauthentic\Validator\FieldBuilder;
use Phauthentic\Validator\FieldCollection;
use Phauthentic\Validator\MessageFormatter\GlossaryMessageFormatter;
use Phauthentic\Validator\Rule\Between;
use Phauthentic\Validator\Rule\NotEmpty;
use Phauthentic\Validator\Validator;
use Phauthentic\Validator\ValidatorFactory;
use PHPUnit\Framework\TestCase;

/**
 * Validator Test
 */
class BasicValidatorTest extends TestCase
{
    protected ValidatorFactory $factory;

    public function setUp(): void
    {
        parent::setUp();

        $this->factory = new ValidatorFactory();
    }

    public function testBasicValidation(): void
    {
        $inputData = [
            'project' => [
                'id' => null,
                'name' => 'It',
                'tasks' => [
                    ['title' => ''],
                    ['title' => 'test'],
                    ['title' => ''],
                ]
            ]
        ];

        $fieldBuilder = FieldBuilder::create(new FieldCollection());
        $fieldBuilder->add('project.id', NotEmpty::NAME);
        $fieldBuilder->add('project.name', Between::NAME, [
            Between::MIN => 3,
            Between::MAX => 10
        ]);
        $fieldBuilder->add('project.tasks.*.title', NotEmpty::NAME);

        $validator = new Validator(
            $fieldBuilder->getFieldCollection(),
            $this->factory->createRuleCollection(),
            new ErrorCollection(),
            new GlossaryMessageFormatter()
        );

        $result = $validator->validate($inputData);

        $this->assertFalse($result->isValid());
        $this->assertEquals(4, $result->getErrors()->count());
    }

    public function testDeeperValidation(): void
    {
        $inputData = [
            'project' => [
                'tasks' => [
                    [
                        'title' => 'Has comments',
                        'comments' => [
                            ['text' => ''],
                            ['text' => 'has text'],
                            ['text' => '']
                        ]
                    ],
                ]
            ]
        ];

        $fieldBuilder = FieldBuilder::create(new FieldCollection());
        $fieldBuilder->add('project.tasks.*.comments.*.text', NotEmpty::NAME);

        $validator = new Validator(
            $fieldBuilder->getFieldCollection(),
            $this->factory->createRuleCollection(),
            new ErrorCollection(),
            new GlossaryMessageFormatter()
        );

        $result = $validator->validate($inputData);

        $this->assertFalse($result->isValid());
        $this->assertEquals(2, $result->getErrors()->count());
    }
}

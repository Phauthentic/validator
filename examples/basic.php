<?php
declare(strict_types=1);

require 'vendor/autoload.php';

use Phauthentic\Validator\Error\ErrorCollection;
use Phauthentic\Validator\Field\FieldBuilder;
use Phauthentic\Validator\Field\FieldCollection;
use Phauthentic\Validator\GlossaryMessageFormatter;
use Phauthentic\Validator\Rule\Between;
use Phauthentic\Validator\Rule\NotEmpty;
use Phauthentic\Validator\Validator;
use Phauthentic\Validator\ValidatorFactory;

function out(string $message) {
    echo $message . PHP_EOL;
}

$input = [
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
$fieldBuilder->add('project.name', Between::NAME, [3,10]);
$fieldBuilder->add('project.tasks.*.title', NotEmpty::NAME);
$fieldCollection = $fieldBuilder->getFieldCollection();

$validator = new Validator(
    $fieldCollection,
    (new ValidatorFactory())->createRuleCollection(),
    new ErrorCollection(),
    new GlossaryMessageFormatter()
);

$result = $validator->validate($input);

if (!$result->isValid()) {
    out('There are ' . $result->getErrors()->count() . ' errors:');
    foreach ($result->getErrors() as $error) {
        out($error->getField()->getName() . ' : ');
        out($error->getMessage());
    }
}

out('/*******************************************************************************');
out(' * Format the output as you wish by using the public methods of the objects.');
out('*******************************************************************************/');

if (!$result->isValid()) {
    $errorArray = [];
    foreach ($result->getErrors() as $error) {
        $errorArray[$error->getField()->getName()][$error->getRule()->getName()] = $error->getMessage();
    }

    var_export($errorArray);
}

# Quick Start

Install the library via composer as usual. If you are not using Composer we assume that you have a very good reason to do so and know what you are doing.
```
composer install phauthentic/validator
```

You can use the factory that is included, but it is recommended to implement your own to set up all your rules in the rules collection.

```php
<?php
declare(strict_types=1);

use Phauthentic\Validator\Rule\Between;
use Phauthentic\Validator\Rule\NotEmpty;
use Phauthentic\Validator\ValidatorFactory;

require 'vendor/autoload.php';

$data = [
    'project' => [
        'id' => null,
        'name' => 'gs',
        'tasks' => [
            ['title' => ''],
            ['title' => 'test'],
            ['title' => ''],
        ]
    ]
];

$validator = (new ValidatorFactory())->createValidator();
$ruleBuilder = $validator->getFieldBuilder();
$ruleBuilder->add('project.id', NotEmpty::NAME);
$ruleBuilder->add('project.name', Between::NAME, [3,10]);
$ruleBuilder->add('project.tasks.*.title', NotEmpty::NAME);

$result = $validator->validate($data);

var_dump($result->getErrors()->toArray());
```

# Phauthentic Validator

![PHP >= 8.0](https://img.shields.io/static/v1?label=PHP&message=8.*&color=787CB5&style=for-the-badge&logo=php)
![phpstan Level 8](https://img.shields.io/static/v1?label=phpstan&message=Level%208&color=%3CCOLOR%3E&style=for-the-badge)
![License: MIT](https://img.shields.io/static/v1?label=License&message=MIT&color=%3CCOLOR%3E&style=for-the-badge)

A [SOLID][1] validation library that also tries to do [KISS][2].

* Designed with maximum flexibility for customization in mind.
* Tries to be as easy to use and set up as possible.
* Doesn't include message translations intentionally - single responsibility principle - but provides the flexibility to hook your own system in.
* Provides a way to customize the error result.
* It is **not** exception driven as some other libs.
* **No** further dependencies.
* Framework-agnostic

## Example

This is a **very** simple **example**. Please read the documentation.

```php
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

if (!$result->isValid()) {
    var_dump($result->getErrors()->toArray());
}
```

## Documentation

 * [Quick Start](docs/Quick-Start.md)
 * [Architecture of the Library](docs/Architecture.md)

## License

[The MIT License (MIT)](LICENSE)

- Copyright (c) 2016-2019 Muhammad Syifa
- Copyright (c) 2021 Dave Redfern
- Copyright (c) 2022 Florian Krämer

[1]: https://en.wikipedia.org/wiki/SOLID
[2]: https://en.wikipedia.org/wiki/KISS_principle

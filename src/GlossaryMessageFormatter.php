<?php

declare(strict_types=1);

namespace Phauthentic\Validator;

use Phauthentic\Validator\Rule\ContextInterface;

/**
 *
 */
class GlossaryMessageFormatter implements MessageFormatterInterface
{
    /**
     * @param array<string, string> $glossary
     */
    public function __construct(
        array $glossary = []
    ) {
        $this->glossary += $glossary;
    }

    /**
     * @var array<string, string>
     */
    protected array $glossary = [
        'rule.notEmpty.default' => 'The field {{fieldName}} can\'t be empty.',
        'rule.between.default' => 'The value {{value}} of field {{fieldName}} is not between {{min}} and {{max}}'
    ];

    public function formatMessage(ContextInterface $context): string
    {
        $rule = $context->getRule();
        $field = $context->getField();

        $message = $field->getRuleDefinition($rule->getName())->getMessage();
        if (!$message) {
            $message = $context->getRule()->getMessage();
        }

        if (isset($this->glossary[$message])) {
            $message = $this->glossary[$message];
        }

        $templateVars = $this->buildTemplateVars($context);

        return $this->parseTemplateString($message, $templateVars);
    }

    /**
     * @param string $templateString
     * @param array<string, mixed> $templateVars
     * @return string
     */
    protected function parseTemplateString(
        string $templateString,
        array $templateVars
    ): string {
        $func = static function (string $value): string {
            return '{{' . $value . '}}';
        };

        $keys = (array_map($func, array_keys($templateVars)));
        $values = array_values($templateVars);

        return str_replace($keys, $values, $templateString);
    }

    /**
     * @return array<string, mixed>
     */
    protected function buildTemplateVars(ContextInterface $context): array
    {
        $templateVars = $context
            ->getField()
            ->getRuleDefinition($context->getRule()->getName())
            ->getArguments();

        $templateVars['value'] = $context->getValue();
        $templateVars['fieldName'] = $context->getField()->getAlias();
        $templateVars['ruleName'] = $context->getRule()->getName();

        return $templateVars;
    }
}

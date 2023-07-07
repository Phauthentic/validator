<?php

declare(strict_types=1);

namespace Phauthentic\Validator\MessageFormatter;

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
        'rule.between.default' => 'The value {{value}} of field {{fieldName}} is not between {{min}} and {{max}}.',
        'rule.email.default' => '{{value}} is not a valid email address.',
        'rule.type.default' => 'The type does not match the expected type.',
        'rule.inList.default' => '{{value}} is not in the list.',
        'rule.count.default' => '{{value}} does not match {{count}}.'
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

        foreach ($templateVars as $variable => $value) {
            $templateString = str_replace(
                '{{' . $variable . '}}',
                $this->typeToString($value),
                $templateString
            );
        }

        return $templateString;
    }

    protected function typeToString(mixed $value): string
    {
        return match (gettype($value)) {
            'resource' => 'Resource',
            'resource (closed)' => 'Resource (closed)',
            'object' => get_class($value),
            'array' => 'Array',
            'NULL' => 'NULL',
            'unknown type' => 'unknown data type',
            default => (string)$value,
        };
    }

    /**
     * @return array<string, mixed>
     */
    protected function buildTemplateVars(ContextInterface $context): array
    {
        $templateVars = $context
            ->getField()
            ->getRuleDefinition($context->getRule()->getName())
            ->getArguments()
            ->toArray();

        $templateVars['value'] = $context->getValue();
        $templateVars['fieldName'] = $context->getField()->getAlias();
        $templateVars['ruleName'] = $context->getRule()->getName();

        return $templateVars;
    }
}

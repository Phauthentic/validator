<?php

declare(strict_types=1);

namespace Phauthentic\Validator;

use Phauthentic\Validator\Rule\RuleCollectionInterface;
use Phauthentic\Validator\Rule\RuleInterface;

/**
 *
 */
abstract class BuilderAwareValidator extends Validator
{
    public function __construct(
        protected FieldCollectionInterface $fieldCollection,
        protected RuleCollectionInterface $ruleCollection,
        protected ErrorCollectionInterface $errorCollection,
        protected MessageFormatterInterface $messageFormatter,
        protected FieldBuilderInterface $fieldBuilder
    ) {
        $this->defineFields($this->fieldBuilder);
    }

    /**
     *
     */
    abstract protected function defineFields(FieldBuilderInterface $fieldBuilder): void;
}

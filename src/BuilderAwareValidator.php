<?php

declare(strict_types=1);

namespace Phauthentic\Validator;

use Phauthentic\Validator\MessageFormatter\MessageFormatterInterface;
use Phauthentic\Validator\Rule\RuleCollectionInterface;

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
        parent::__construct(
            $this->fieldCollection,
            $this->ruleCollection,
            $this->errorCollection,
            $this->messageFormatter
        );

        $this->defineFields($this->fieldBuilder);
    }

    /**
     *
     */
    abstract protected function defineFields(FieldBuilderInterface $fieldBuilder): void;
}

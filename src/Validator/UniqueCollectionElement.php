<?php

namespace App\Validator;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class UniqueCollectionElement extends Constraint
{
    public function __construct(
        public string $field,
        public string $label,
        public string $message = 'L\'élément {{ label }} est présent plusieurs fois',
        mixed $options = null,
        ?array $groups = null,
        mixed $payload = null,
    ) {
        parent::__construct($options, $groups, $payload);
    }
}

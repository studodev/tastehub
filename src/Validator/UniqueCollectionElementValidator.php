<?php

namespace App\Validator;

use IteratorAggregate;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class UniqueCollectionElementValidator extends ConstraintValidator
{
    public function __construct(private readonly PropertyAccessorInterface $propertyAccessor)
    {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!is_array($value) && !$value instanceof IteratorAggregate) {
            throw new UnexpectedValueException($value, 'array|IteratorAggregate');
        }

        if (count($value) < 1) {
            return;
        }

        $elements = [];
        $invalidElements = [];

        foreach ($value as $item) {
            $element = $this->propertyAccessor->getValue($item, $constraint->field);

            if (in_array($element, $elements)) {
                if (!in_array($element, $invalidElements)) {
                    $invalidElements[] = $element;

                    $label = $this->propertyAccessor->getValue($element, $constraint->label);
                    $this->context
                        ->buildViolation($constraint->message)
                        ->setParameter('{{ label }}', $label)
                        ->addViolation()
                    ;
                }
            }

            $elements[] = $element;
        }
    }
}

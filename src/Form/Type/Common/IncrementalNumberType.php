<?php

namespace App\Form\Type\Common;

use Symfony\Component\Form\AbstractType;

class IncrementalNumberType extends AbstractType
{
    public function getParent(): string
    {
        return FormattedNumberType::class;
    }
}

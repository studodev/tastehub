<?php

namespace App\Form\Type\Common;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TextareaCountableType extends AbstractCountableType
{
    public function getParent(): string
    {
        return TextareaType::class;
    }
}

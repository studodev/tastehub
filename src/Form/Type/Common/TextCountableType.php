<?php

namespace App\Form\Type\Common;

use Symfony\Component\Form\Extension\Core\Type\TextType;

class TextCountableType extends AbstractCountableType
{
    public function getParent(): string
    {
        return TextType::class;
    }
}

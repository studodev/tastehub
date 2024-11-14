<?php

namespace App\Form\Type\Common;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IncrementalNumberType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'grouping' => true,
        ]);
    }

    public function getParent(): string
    {
        return IntegerType::class;
    }
}

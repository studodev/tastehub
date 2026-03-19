<?php

declare(strict_types=1);

namespace App\Form\Type\Common;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RatingType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => false,
            'choices' => [
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                '5' => 5,
            ],
            'choice_label' => function ($choice) {
                return sprintf('<span class="sr-only">%d</span>', $choice);
            },
            'row_attr' => [
                'class' => 'rating-widget',
            ],
            'label_html' => true,
            'expanded' => true,
            'multiple' => false,
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}

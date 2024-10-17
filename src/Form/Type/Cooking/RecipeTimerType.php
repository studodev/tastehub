<?php

namespace App\Form\Type\Cooking;

use App\Model\Cooking\RecipeTimer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeTimerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('preparationTime', null, [
                'label' => 'minutes de <span class="accent">préparation</span>',
                'label_html' => true,
                'attr' => [
                    'placeholder' => '...',
                ],
            ])
            ->add('waitingTime', null, [
                'label' => 'minutes de <span class="accent">pose</span>',
                'label_html' => true,
                'label_attr' => [
                    'class' => 'silent-optional-badge',
                ],
                'attr' => [
                    'placeholder' => '...',
                ],
            ])
            ->add('cookingTime', null, [
                'label' => 'minutes de <span class="accent">cuisson</span>',
                'label_html' => true,
                'label_attr' => [
                    'class' => 'silent-optional-badge',
                ],
                'attr' => [
                    'placeholder' => '...',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RecipeTimer::class,
        ]);
    }
}

<?php

namespace App\Form\Type\Cooking;

use App\Model\Cooking\RecipeTimer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeTimerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('preparationTime', IntegerType::class, [
                'label' => 'minutes de <span class="accent">préparation</span>',
                'label_html' => true,
                'error_bubbling' => true,
                'grouping' => true,
                'invalid_message' => 'Le temps de préparation doit être un nombre entier',
                'attr' => [
                    'placeholder' => '...',
                    'class' => 'timer-preparation',
                    'maxlength' => 4,
                ],
            ])
            ->add('waitingTime', IntegerType::class, [
                'label' => 'minutes de <span class="accent">pose</span>',
                'label_html' => true,
                'label_attr' => [
                    'class' => 'silent-optional-badge',
                ],
                'error_bubbling' => true,
                'grouping' => true,
                'invalid_message' => 'Le temps de pose doit être un nombre entier',
                'attr' => [
                    'placeholder' => '...',
                    'class' => 'timer-waiting',
                    'maxlength' => 4,
                ],
            ])
            ->add('cookingTime', IntegerType::class, [
                'label' => 'minutes de <span class="accent">cuisson</span>',
                'label_html' => true,
                'label_attr' => [
                    'class' => 'silent-optional-badge',
                ],
                'error_bubbling' => true,
                'grouping' => true,
                'invalid_message' => 'Le temps de cuisson doit être un nombre entier',
                'attr' => [
                    'placeholder' => '...',
                    'class' => 'timer-cooking',
                    'maxlength' => 4,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RecipeTimer::class,
            'error_bubbling' => false,
        ]);
    }
}

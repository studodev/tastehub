<?php

namespace App\Form\Type\Cooking;

use App\Entity\Cooking\Recipe;
use App\Entity\Cooking\Step;
use App\Form\Type\Common\TextareaCountableType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number')
            ->add('stepRecipeIngredientGenerator', StepRecipeIngredientType::class, [
                'label' => false,
                'mapped' => false,
                'recipe' => $options['recipe'],
            ])
            ->add('stepRecipeIngredients', CollectionType::class, [
                'entry_type' => StepRecipeIngredientType::class,
                'entry_options' => [
                    'label' => false,
                    'recipe' => $options['recipe'],
                    'mode' => StepRecipeIngredientType::MODE_COLLECTION,
                ],
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'error_bubbling' => false,
                'prototype_name' => '__item__',
                'attr' => [
                    'class' => 'item-holder',
                ],
            ])
            ->add('description', TextareaCountableType::class, [
                'max_length' => Step::DESCRIPTION_MAX_LENGTH,
                'label' => 'Instructions',
                'attr' => [
                    'rows' => 6,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Step::class,
        ]);

        $resolver
            ->setRequired('recipe')
            ->setAllowedTypes('recipe', Recipe::class)
        ;
    }
}

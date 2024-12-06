<?php

namespace App\Form\Type\Cooking;

use App\Entity\Cooking\Ingredient;
use App\Entity\Cooking\RecipeIngredient;
use App\Enum\Cooking\IngredientUnitEnum;
use App\Form\Type\Common\AutocompleteEntityType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeIngredientType extends AbstractType
{
    const MODE_SOURCE = 'source';
    const MODE_COLLECTION = 'collection';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if (self::MODE_SOURCE === $options['mode']) {
            $builder->add('ingredient', AutocompleteEntityType::class, [
                'label' => 'Ingredient',
                'class' => Ingredient::class,
                'choice_label' => 'label',
                'placeholder' => '',
                'placeholder_content' => 'Rechercher un ingredient ...',
                'autocomplete_route' => 'cooking_ingredient_autocomplete',
                'attr' => [
                    'class' => 'item-data-ingredient',
                ]
            ]);
        } else {
            $builder->add('ingredient', EntityType::class, [
                'class' => Ingredient::class,
                'label' => false,
                'choice_label' => 'label',
                'attr' => [
                    'class' => 'item-data-ingredient hidden',
                ]
            ]);
        }


        $builder
            ->add('quantity', null, [
                'label' => 'Quantité',
                'attr' => [
                    'class' => 'item-data-quantity',
                ]
            ])
            ->add('unit', EnumType::class, [
                'label' => 'Unité de mesure',
                'class' => IngredientUnitEnum::class,
                'attr' => [
                    'class' => 'item-data-unit',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RecipeIngredient::class,
            'mode' => self::MODE_SOURCE,
        ]);
    }
}

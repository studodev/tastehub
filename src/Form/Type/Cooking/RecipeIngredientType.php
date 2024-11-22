<?php

namespace App\Form\Type\Cooking;

use App\Entity\Cooking\Ingredient;
use App\Entity\Cooking\RecipeIngredient;
use App\Enum\Cooking\QuantityCounterUnitEnum;
use App\Form\Type\Common\AutocompleteEntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeIngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ingredient', AutocompleteEntityType::class, [
                'label' => 'Ingredient',
                'class' => Ingredient::class,
                'choice_label' => 'label',
                'placeholder' => '',
                'placeholder_content' => 'Rechercher un ingredient ...',
                'autocomplete_route' => 'cooking_ingredient_autocomplete',
            ])
            ->add('quantity', null, [
                'label' => 'Quantité',
            ])
            ->add('unit', EnumType::class, [
                'label' => 'Unité de mesure',
                'class' => QuantityCounterUnitEnum::class,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RecipeIngredient::class,
        ]);
    }
}

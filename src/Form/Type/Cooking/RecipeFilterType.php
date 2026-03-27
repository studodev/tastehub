<?php

namespace App\Form\Type\Cooking;

use App\Entity\Cooking\Category;
use App\Entity\Cooking\DietType;
use App\Entity\Cooking\Tag;
use App\Enum\Cooking\RecipeDurationRangeEnum;
use App\Enum\Cooking\RecipeSortEnum;
use App\Form\Type\Common\AutocompleteEntityType;
use App\Model\Cooking\RecipeFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('query', SearchType::class, [
                'label' => 'Rechercher une recette, un ingrédient...',
                'attr' => [
                    'placeholder' => 'Steak-Frites, Camembert...',
                ],
                'row_attr' => [
                    'class' => 'highlight-row',
                ],
            ])
            ->add('categories', AutocompleteEntityType::class, [
                'class' => Category::class,
                'label' => 'Catégories',
                'choice_label' => 'label',
                'multiple' => true,
                'placeholder_content' => 'Tout afficher',
            ])
            ->add('diets', AutocompleteEntityType::class, [
                'class' => DietType::class,
                'label' => 'Régimes spécifiques',
                'choice_label' => 'label',
                'multiple' => true,
                'placeholder_content' => 'Tout afficher',
            ])
            ->add('tags', AutocompleteEntityType::class, [
                'class' => Tag::class,
                'label' => 'Tags thématiques',
                'choice_label' => 'label',
                'multiple' => true,
                'autocomplete_route' => 'cooking_tag_autocomplete',
                'placeholder_content' => 'Tout afficher',
            ])
            ->add('duration', EnumType::class, [
                'class' => RecipeDurationRangeEnum::class,
                'label' => 'Durée de la recette',
                'placeholder' => 'Tout afficher',
            ])
            ->add('sort', EnumType::class, [
                'class' => RecipeSortEnum::class,
                'label' => 'Trier',
                'row_attr' => [
                    'class' => 'highlight-row',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RecipeFilter::class,
            'method' => 'GET',
            'attr' => [
                'class' => 'async-list-filter',
            ],
        ]);
    }
}

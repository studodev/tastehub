<?php

namespace App\Form\Type\Cooking;

use App\Entity\Cooking\Ingredient;
use App\Entity\Cooking\RecipeIngredient;
use App\Enum\Cooking\IngredientUnitEnum;
use App\Enum\PictogramTypeEnum;
use App\Form\Type\Common\AutocompleteEntityType;
use App\Service\PictogramService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeIngredientType extends AbstractType
{
    const MODE_SOURCE = 'source';
    const MODE_COLLECTION = 'collection';

    public function __construct(private readonly PictogramService $pictogramService)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $mode = $options['mode'];

        if (self::MODE_SOURCE === $options['mode']) {
            $builder->add('ingredient', AutocompleteEntityType::class, [
                'label' => 'Ingredient',
                'class' => Ingredient::class,
                'choice_label' => 'label',
                'choice_attr' => function (Ingredient $ingredient) {
                    return [
                        'data-pictogram' => $this->pictogramService->buildUrl(PictogramTypeEnum::Ingredient, $ingredient->getType()->getPictogram()),
                    ];
                },
                'placeholder' => '',
                'placeholder_content' => 'Rechercher un ingredient ...',
                'autocomplete_route' => 'cooking_ingredient_autocomplete',
                'attr' => [
                    'class' => 'item-data-ingredient',
                ]
            ]);

            $quantityAttr = [];
            $unitAttr = [];
        } else {
            $builder->add('ingredient', EntityType::class, [
                'class' => Ingredient::class,
                'label' => false,
                'choice_label' => 'label',
                'attr' => [
                    'class' => 'item-data-ingredient hidden',
                ]
            ]);

            $quantityAttr = [
                'aria-label' => 'Quantité',
            ];
            $unitAttr = [
                'aria-label' => 'Unité de mesure',
            ];
        }


        $builder
            ->add('quantity', null, [
                'label' => self::MODE_SOURCE === $mode ? 'Quantité' : false,
                'attr' => [
                    'class' => 'item-data-quantity',
                    ...$quantityAttr,
                ],
            ])
            ->add('unit', EnumType::class, [
                'label' => self::MODE_SOURCE === $mode ? 'Unité de mesure' : false,
                'class' => IngredientUnitEnum::class,
                'attr' => [
                    'class' => 'item-data-unit',
                    ...$unitAttr,
                ],
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

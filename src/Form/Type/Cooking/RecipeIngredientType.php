<?php

namespace App\Form\Type\Cooking;

use App\Entity\Cooking\Ingredient;
use App\Entity\Cooking\RecipeIngredient;
use App\Entity\Cooking\Unit;
use App\Enum\Common\PictogramTypeEnum;
use App\Form\Type\Common\AutocompleteEntityType;
use App\Form\Type\Common\FormattedNumberType;
use App\Service\Common\PictogramService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class RecipeIngredientType extends AbstractType
{
    public const string MODE_SOURCE = 'source';
    public const string MODE_COLLECTION = 'collection';

    public function __construct(
        private readonly PictogramService $pictogramService,
        private readonly TranslatorInterface $translator,
    ) {
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
                ],
            ]);

            $unitOptions = [
                'placeholder' => 'Choisissez une unité',
                'choice_label' => 'displayName',
            ];
        } else {
            $builder->add('ingredient', EntityType::class, [
                'class' => Ingredient::class,
                'label' => false,
                'choice_label' => 'label',
                'attr' => [
                    'class' => 'item-data-ingredient',
                ],
            ]);

            $unitOptions = [
                'choice_label' => 'displaySymbol',
            ];
        }

        $builder
            ->add('quantity', FormattedNumberType::class, [
                'label' => self::MODE_SOURCE === $mode ? 'Quantité' : false,
                'label_attr' => [
                    'class' => 'silent-optional-badge',
                ],
                'attr' => [
                    'class' => 'item-data-quantity',
                ],
                'error_bubbling' => true,
                'scale' => 2,
                'min' => 0.1,
                'max' => RecipeIngredient::MAX_QUANTITY,
            ])
            ->add('unit', null, [
                'label' => self::MODE_SOURCE === $mode ? 'Unité de mesure' : false,
                'class' => Unit::class,
                'group_by' => function (Unit $unit) {
                    return $unit->getType()->trans($this->translator);
                },
                'attr' => [
                    'class' => 'item-data-unit',
                ],
                'choice_attr' => function (Unit $unit) {
                    return [
                        'data-plural' => $unit->getDisplaySymbol(true),
                        'data-empirical' => $unit->getType()->isEmpirical() ? null : false,
                    ];
                },
                'error_bubbling' => true,
                ...$unitOptions,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RecipeIngredient::class,
            'mode' => self::MODE_SOURCE,
            'error_bubbling' => false,
        ]);
    }
}

<?php

namespace App\Form\Type\Cooking;

use App\Entity\Cooking\Ingredient;
use App\Entity\Cooking\RecipeIngredient;
use App\Entity\Cooking\Unit;
use App\Enum\Common\PictogramTypeEnum;
use App\Form\Type\Common\AutocompleteEntityType;
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
                'placeholder' => 'Unité',
                'choice_label' => 'symbol',
            ];
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
                'label_attr' => [
                    'class' => 'silent-optional-badge',
                ],
                'attr' => [
                    'class' => 'item-data-quantity',
                    ...$quantityAttr ?? [],
                ],
                'error_bubbling' => true,
            ])
            ->add('unit', null, [
                'label' => self::MODE_SOURCE === $mode ? 'Unité de mesure' : false,
                'class' => Unit::class,
                'group_by' => function (Unit $unit) {
                    return $unit->getType()->trans($this->translator);
                },
                'attr' => [
                    'class' => 'item-data-unit',
                    ...$unitAttr ?? [],
                ],
                'choice_attr' => function (Unit $unit) {
                    return [
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

<?php

namespace App\Form\Type\Cooking;

use App\Entity\Cooking\Recipe;
use App\Entity\Cooking\RecipeIngredient;
use App\Entity\Cooking\StepRecipeIngredient;
use App\Enum\Common\PictogramTypeEnum;
use App\Service\Common\PictogramService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StepRecipeIngredientType extends AbstractType
{
    public const MODE_SOURCE = 'source';
    public const MODE_COLLECTION = 'collection';

    public function __construct(private readonly PictogramService $pictogramService)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if (self::MODE_COLLECTION === $options['mode']) {
            $builder->add('quantity', null, [
                'label' => 'Quantité à utiliser',
                'attr' => [
                    'class' => 'item-data-quantity',
                ],
            ]);

            $recipeIngredientOptions = [
                'label' => false,
                'row_attr' => [
                    'class' => 'hidden',
                ]
            ];
        } else {
            $recipeIngredientOptions = [
                'label' => 'Ingrédients de l\'étape',
                'placeholder' => 'Choisissez un ingredient ...',
            ];
        }

        $builder->add('recipeIngredient', EntityType::class, [
            'class' => RecipeIngredient::class,
            'choices' => $options['recipe']->getRecipeIngredients(),
            'choice_label' => 'ingredient.label',
            'choice_attr' => function (RecipeIngredient $recipeIngredient) {
                $pictogram = $recipeIngredient->getIngredient()->getType()->getPictogram();

                return [
                    'data-pictogram' => $this->pictogramService->buildUrl(PictogramTypeEnum::Ingredient, $pictogram),
                    'data-quantity' => $recipeIngredient->getQuantity(),
                    'data-quantity-unit' => $recipeIngredient->getUnit()->value,
                ];
            },
            'attr' => [
                'class' => 'item-data-ingredient',
            ],
            ...$recipeIngredientOptions,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StepRecipeIngredient::class,
            'mode' => self::MODE_SOURCE,
        ]);

        $resolver
            ->setRequired('recipe')
            ->setAllowedTypes('recipe', Recipe::class)
        ;
    }
}

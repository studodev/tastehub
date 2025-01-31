<?php

namespace App\Form\Type\Cooking;

use App\Entity\Cooking\Category;
use App\Entity\Cooking\CookingMethod;
use App\Entity\Cooking\DietType;
use App\Entity\Cooking\Recipe;
use App\Entity\Cooking\Tag;
use App\Entity\Cooking\Utensil;
use App\Enum\Cooking\DraftRecipeStatusEnum;
use App\Form\Type\Common\AutocompleteEntityType;
use App\Form\Type\Common\FileUploaderType;
use App\Form\Type\Common\TextareaCountableType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Event\SubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $mode = $options['mode'];

        match ($mode) {
            DraftRecipeStatusEnum::Metadata => $this->prepareMetadataMode($builder),
            DraftRecipeStatusEnum::Details => $this->prepareDetailsMode($builder),
            DraftRecipeStatusEnum::Ingredients => $this->prepareIngredientsMode($builder),
            DraftRecipeStatusEnum::Utensils => $this->prepareUtensilsMode($builder),
            DraftRecipeStatusEnum::Steps => $this->prepareSteps($builder),
        };
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
            'validation_groups' => function (FormInterface $form): array {
                $mode = $form->getConfig()->getOption('mode');

                return ['Default', $mode->value];
            },
        ]);

        $resolver->setRequired('mode');
        $resolver->setAllowedTypes('mode', DraftRecipeStatusEnum::class);
    }

    private function prepareMetadataMode(FormBuilderInterface $builder): void
    {
        $builder
            ->add('title', null, [
                'label' => 'Nom de la recette',
                'row_attr' => [
                    'class' => 'highlight-row',
                ],
                'attr' => [
                    'placeholder' => 'Poulet au maroilles, mijoté de poisson au curry, cookies aux 3 chocolats, ...',
                ],
            ])
            ->add('description', TextareaCountableType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Est-ce un plat issu d\'une recette de famille ? Une recette que vous conseillez pour Noël ? Une recette découverte dans un autre pays que vous avez décidé de traduire ? Racontez-nous l\'histoire de cette recette',
                    'rows' => 8,
                ],
                'max_length' => Recipe::DESCRIPTION_MAX_LENGTH,
            ])
            ->add('pictureFile', FileUploaderType::class, [
                'label' => 'Photo de la recette',
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'label',
                'label' => 'Catégorie',
                'expanded' => true,
            ])
        ;
    }

    private function prepareDetailsMode(FormBuilderInterface $builder): void
    {
        $builder
            ->add('timer', RecipeTimerType::class, [
                'label' => 'Temps de réalisation',
                'help' => 'Seul le champ <span class="accent">préparation</span> est obligatoire. Le <span class="accent">temps total</span> est calculé automatiquement.',
                'help_html' => true,
            ])
            ->add('quantityCounter', QuantityCounterType::class, [
                'label' => 'Quantité réalisée',
            ])
            ->add('diets', EntityType::class, [
                'label' => 'Régimes',
                'required' => false,
                'class' => DietType::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => function (DietType $dietType) {
                    return sprintf('%s <i class="icon icon-%s"></i>', $dietType->getLabel(), $dietType->getIcon());
                },
                'label_html' => true,
            ])
            ->add('cookingMethods', EntityType::class, [
                'label' => 'Modes de cuisson',
                'class' => CookingMethod::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => function (CookingMethod $cookingMethod) {
                    return sprintf('%s <i class="icon icon-%s"></i>', $cookingMethod->getLabel(), $cookingMethod->getIcon());
                },
                'label_html' => true,
            ])
            ->add('tags', AutocompleteEntityType::class, [
                'label' => 'Tags',
                'class' => Tag::class,
                'choice_label' => 'label',
                'multiple' => true,
                'placeholder_content' => 'Rechercher des tags ...',
                'autocomplete_route' => 'cooking_tag_autocomplete',
                'max_items' => Recipe::MAX_TAGS,
            ])
        ;
    }

    private function prepareIngredientsMode(FormBuilderInterface $builder): void
    {
        $builder
            ->add('recipeIngredientGenerator', RecipeIngredientType::class, [
                'label' => false,
                'mapped' => false,
            ])
            ->add('recipeIngredients', CollectionType::class, [
                'entry_type' => RecipeIngredientType::class,
                'entry_options' => [
                    'label' => false,
                    'mode' => RecipeIngredientType::MODE_COLLECTION,
                ],
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'error_bubbling' => false,
                'attr' => [
                    'class' => 'item-holder',
                ],
            ])
        ;
    }

    private function prepareUtensilsMode(FormBuilderInterface $builder): void
    {
        $builder
            ->add('utensilGenerator', AutocompleteEntityType::class, [
                'label' => false,
                'mapped' => false,
                'class' => Utensil::class,
                'choice_label' => 'label',
                'placeholder' => '',
                'placeholder_content' => 'Rechercher un ustensile ...',
                'autocomplete_route' => 'cooking_utensil_autocomplete',
                'attr' => [
                    'class' => 'item-data-utensil',
                ],
            ])
            ->add('utensils', CollectionType::class, [
                'entry_type' => EntityType::class,
                'entry_options' => [
                    'label' => false,
                    'class' => Utensil::class,
                    'choice_label' => 'label',
                    'attr' => [
                        'class' => 'item-data-utensil hidden',
                    ],
                ],
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'error_bubbling' => false,
                'attr' => [
                    'class' => 'item-holder',
                ],
            ])
        ;
    }

    private function prepareSteps(FormBuilderInterface $builder): void
    {
        $builder
            ->add('steps', CollectionType::class, [
                'entry_type' => StepType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false,
            ])
            ->addEventListener(
                FormEvents::PRE_SUBMIT,
                [$this, 'reorderSteps']
            )
            ->addEventListener(
                FormEvents::SUBMIT,
                [$this, 'defineStepNumber']
            )
        ;
    }

    public function reorderSteps(PreSubmitEvent $event): void
    {
        $data = $event->getData();

        if (!array_key_exists('steps', $data)) {
            return;
        }

        $data['steps'] = array_values($data['steps']);
        $event->setData($data);
    }

    public function defineStepNumber(SubmitEvent $event): void
    {
        $recipe = $event->getData();

        foreach ($recipe->getSteps() as $i => $step) {
            $step->setNumber($i);
        }
    }
}

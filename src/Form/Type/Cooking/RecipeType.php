<?php

namespace App\Form\Type\Cooking;

use App\Entity\Cooking\Category;
use App\Entity\Cooking\CookingMethod;
use App\Entity\Cooking\DietType;
use App\Entity\Cooking\Recipe;
use App\Enum\Cooking\DraftRecipeStatusEnum;
use App\Form\Type\Common\FileUploaderType;
use App\Form\Type\Common\TextareaCountableType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $mode = $options['mode'];

        if (DraftRecipeStatusEnum::Metadata === $mode) {
            $this->prepareMetadataMode($builder);
        } elseif (DraftRecipeStatusEnum::Details === $mode) {
            $this->prepareDetailsMode($builder);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
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
                'max_length' => 350,
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
        ;
    }
}



//    ->add('tags', EntityType::class, [
//        'class' => Tag::class,
//        'choice_label' => 'id',
//        'multiple' => true,
//    ])

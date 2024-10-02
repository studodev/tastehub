<?php

namespace App\Form\Type\Cooking;

use App\Entity\Cooking\Category;
use App\Entity\Cooking\Recipe;
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

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}

//    ->add('timer')
//    ->add('quantityCounter')
//    ->add('diets', EntityType::class, [
//        'class' => DietType::class,
//        'choice_label' => 'id',
//        'multiple' => true,
//    ])
//    ->add('cookingMethods', EntityType::class, [
//        'class' => CookingMethod::class,
//        'choice_label' => 'id',
//        'multiple' => true,
//    ])
//    ->add('tags', EntityType::class, [
//        'class' => Tag::class,
//        'choice_label' => 'id',
//        'multiple' => true,
//    ])

<?php

namespace App\Form\Type\Cooking;

use App\Entity\Cooking\Review;
use App\Form\Type\Common\RatingType;
use App\Form\Type\Common\TextareaCountableType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rating', RatingType::class)
            ->add('comment', TextareaCountableType::class, [
                'label' => 'Commentaire',
                'max_length' => Review::COMMENT_MAX_LENGTH,
                'required' => false,
                'attr' => [
                    'rows' => 4,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}

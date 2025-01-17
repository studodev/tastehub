<?php

namespace App\Form\Type\Cooking;

use App\Entity\Cooking\Step;
use App\Form\Type\Common\TextareaCountableType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('number')
            ->add('description', TextareaCountableType::class, [
                'max_length' => Step::DESCRIPTION_MAX_LENGTH,
                'label' => 'Instructions',
                'attr' => [
                    'rows' => 6,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Step::class,
        ]);
    }
}

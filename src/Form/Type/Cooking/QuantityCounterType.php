<?php

namespace App\Form\Type\Cooking;

use App\Enum\Cooking\QuantityCounterUnitEnum;
use App\Form\Type\Common\IncrementalNumberType;
use App\Model\Cooking\QuantityCounter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuantityCounterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('value', IncrementalNumberType::class, [
                'label' => false,
                'error_bubbling' => true,
                'invalid_message' => 'La quantité réalisée doit être un nombre entier',
                'attr' => [
                    'class' => 'input-value',
                    'maxlength' => 3,
                ],
            ])
            ->add('unit', EnumType::class, [
                'class' => QuantityCounterUnitEnum::class,
                'label' => false,
                'expanded' => true,
                'error_bubbling' => true,
                'row_attr' => [
                    'class' => 'unit-selector',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => QuantityCounter::class,
            'error_bubbling' => false,
        ]);
    }
}

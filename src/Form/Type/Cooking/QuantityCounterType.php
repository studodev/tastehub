<?php

namespace App\Form\Type\Cooking;

use App\Enum\Cooking\QuantityCounterUnitEnum;
use App\Form\Type\Common\IncrementalNumberType;
use App\Model\Cooking\QuantityCounter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuantityCounterType extends AbstractType
{
    public const string MODE_EDITOR = 'editor';
    public const string MODE_VIEW = 'view';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('value', IncrementalNumberType::class, [
                'label' => false,
                'error_bubbling' => true,
                'invalid_message' => 'La quantité réalisée doit être un nombre entier',
                'min' => QuantityCounter::MIN_VALUE,
                'max' => QuantityCounter::MAX_VALUE,
                'attr' => [
                    'class' => 'input-value',
                    'maxlength' => 3,
                ],
            ])
        ;

        if (self::MODE_EDITOR === $options['mode']) {
            $builder->add('unit', EnumType::class, [
                'class' => QuantityCounterUnitEnum::class,
                'label' => false,
                'expanded' => true,
                'error_bubbling' => true,
                'row_attr' => [
                    'class' => 'unit-selector',
                ],
            ]);
        }
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['mode'] = $options['mode'];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => QuantityCounter::class,
            'error_bubbling' => false,
            'mode' => self::MODE_EDITOR,
        ]);

        $resolver->setAllowedValues('mode', [self::MODE_EDITOR, self::MODE_VIEW]);
    }
}

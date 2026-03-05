<?php

namespace App\Form\Type\Common;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormattedNumberType extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $attr = [
            'data-number-widget' => null,
            'data-scale' => $options['scale'],
            'data-min' => $options['min'],
            'data-max' => $options['max'],
        ];

        $view->vars['attr'] = array_merge($view->vars['attr'], $attr);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'scale' => 0,
            'min' => 0,
            'max' => PHP_INT_MAX,
        ]);

        $resolver->setAllowedTypes('scale', 'int');
        $resolver->setAllowedTypes('min', ['int', 'float']);
        $resolver->setAllowedTypes('max', ['int', 'float']);
    }

    public function getParent(): string
    {
        return NumberType::class;
    }
}

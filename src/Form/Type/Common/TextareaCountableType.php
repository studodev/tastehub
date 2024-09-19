<?php

namespace App\Form\Type\Common;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextareaCountableType extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $attr = [
            'data-max-length' => $options['max_length'],
        ];

        if (!empty($options['min_length'])) {
            $attr['data-min-length'] = $options['min_length'];
        }

        $view->vars['attr'] = array_merge($view->vars['attr'], $attr);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired('max_length');
        $resolver->setAllowedTypes('max_length', 'int');

        $resolver->setDefined('min_length');
        $resolver->setAllowedTypes('min_length', 'int');
    }

    public function getParent(): string
    {
        return TextareaType::class;
    }
}

<?php

namespace App\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class CollectionIndexExtension extends AbstractTypeExtension
{
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $children = $form->all();

        $view->vars['attr'] = array_merge([
            'data-index' => end($children)->getName() + 1,
        ], $view->vars['attr']);
    }

    public static function getExtendedTypes(): iterable
    {
        return [CollectionType::class];
    }
}

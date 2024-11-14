<?php

namespace App\Form\Type\Common;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSetDataEvent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

// TODO - Reload choices from request
class AutocompleteEntityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (PreSetDataEvent $event) use (&$options) {
            $data = $event->getData();
            $options['choices'] = is_iterable($data) ? $data : [$data];
        });
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['placeholder_content'] = $options['placeholder_content'];
        $view->vars['autocomplete_route'] = $options['autocomplete_route'];
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'placeholder_content' => null,
        ]);

        $resolver->setAllowedTypes('placeholder_content', ['null', 'string']);

        $resolver->setRequired('autocomplete_route');
        $resolver->setAllowedTypes('autocomplete_route', ['string']);
    }

    public function getParent(): string
    {
        return EntityType::class;
    }
}

<?php

namespace App\Form\Type\Common;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSetDataEvent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;

class AutocompleteEntityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (PreSetDataEvent $event) use (&$options) {
            $data = $event->getData();
            $options['choices'] = is_iterable($data) ? $data : [$data];
        });
    }

    public function getParent(): string
    {
        return EntityType::class;
    }
}

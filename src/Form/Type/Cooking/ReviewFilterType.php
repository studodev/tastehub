<?php

namespace App\Form\Type\Cooking;

use App\Enum\Cooking\ReviewSortEnum;
use App\Model\Cooking\ReviewFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sort', EnumType::class, [
                'class' => ReviewSortEnum::class,
                'label' => 'Trier',
                'row_attr' => [
                    'class' => 'sort-row',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReviewFilter::class,
            'method' => 'GET',
            'attr' => [
                'class' => 'async-list-filter',
            ],
        ]);
    }
}

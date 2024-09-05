<?php

namespace App\Form\Type\User;

use App\Entity\User\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'attr' => [
                    'autofocus' => null,
                ],
            ])
            ->add('username', null, [
                'label' => 'Nom d\'utilisateur',
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe',
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'J\'accepte les conditions générales d\'utilisations',
                'mapped' => false,
                'constraints' => [
                    new IsTrue(message: 'Vous devez accepter les CGU'),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

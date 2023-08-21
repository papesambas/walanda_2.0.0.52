<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('roles')
            ->add('password')
            ->add('email')
            ->add('telephone')
            ->add('adresse')
            ->add('fullname')
            ->add('isVerified')
            ->add('resetToken')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('slug')
            ->add('nom')
            ->add('prenom')
            ->add('eleves')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
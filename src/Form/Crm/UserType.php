<?php

namespace App\Form\Crm;

use App\Entity\Crm\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('created')
            ->add('updated')
            ->add('username')
            ->add('password')
            ->add('lastLoggedIn')
            ->add('lastIp')
            ->add('createdBy')
            ->add('updatedBy')
            ->add('person')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

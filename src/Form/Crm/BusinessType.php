<?php

namespace App\Form\Crm;

use App\Entity\Crm\Business;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BusinessType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type')
            ->add('created')
            ->add('updated')
            ->add('name')
            ->add('businessNumber')
            ->add('createdBy')
            ->add('updatedBy')
            ->add('people')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Business::class,
        ]);
    }
}

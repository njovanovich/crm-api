<?php

namespace App\Form\Crm;

use App\Entity\Crm\JobProperties;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobPropertiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('created')
            ->add('updated')
            ->add('name')
            ->add('value')
            ->add('createdBy')
            ->add('updatedBy')
            ->add('jobId')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => JobProperties::class,
        ]);
    }
}

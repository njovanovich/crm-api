<?php

namespace App\Form\Crm;

use App\Entity\Crm\Job;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('created')
            ->add('updated')
            ->add('jobId')
            ->add('name')
            ->add('deliveryDate')
            ->add('createdBy')
            ->add('updatedBy')
            ->add('jobProperties')
            ->add('notes')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Job::class,
        ]);
    }
}

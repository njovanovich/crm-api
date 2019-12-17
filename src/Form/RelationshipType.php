<?php

namespace App\Form;

use App\Entity\Relationship;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RelationshipType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('type')
            ->add('aliases')
            ->add('startTime')
            ->add('endTime')
            ->add('created')
            ->add('updated')
            ->add('lhsEntity')
            ->add('rhsEntity')
            ->add('createdBy')
            ->add('updatedBy')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Relationship::class,
        ]);
    }
}

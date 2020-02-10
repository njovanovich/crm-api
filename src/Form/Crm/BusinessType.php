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
            ->add("abn")
            ->add("acn")
            ->add("miscCodes")
            ->add("numberOfEmployees")
            ->add("industry")
            ->add("annualRevenue")
            ->add("type")
            ->add("name")
            ->add("website")
            ->add("phone")
            ->add("fax")
            ->add("email")
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Business::class,
        ]);
    }
}

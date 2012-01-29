<?php

namespace restoo\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PackageType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('startDate')
            ->add('endDate')
        ;
    }

    public function getName()
    {
        return 'restoo_mainbundle_packagetype';
    }
}

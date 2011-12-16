<?php

namespace restoo\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class JobType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('alias')
            ->add('title')
            ->add('description')
            ->add('effort')
            ->add('reporter')
            ->add('receiver')
        ;
    }

    public function getName()
    {
        return 'restoo_mainbundle_jobtype';
    }
}

<?php

namespace restoo\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class JobPackageType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
			->add('calendar_week')
			->add('status')
        ;
    }

    public function getName()
    {
        return 'restoo_mainbundle_jobpackagetype';
    }
}

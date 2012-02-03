<?php

namespace restoo\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PackageType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('startDate')
            ->add('endDate')
        	->add('jobs', 'collection', array(	
        				'type' => new JobType(),
        				'allow_add' => true,
        				'by_reference' => false 
       		));
    }

    public function getName()
    {
        return 'package';
    }
}

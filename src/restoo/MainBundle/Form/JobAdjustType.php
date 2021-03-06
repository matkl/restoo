<?php

namespace restoo\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * Form-Type for the adjusting of a job entity.
 * 
 * @author jochen
 */
class JobAdjustType extends AbstractType
{
    public function buildForm( FormBuilder $builder, array $options )
    {
        $builder
        	->add('effort')
        	->add('receiver')
        ;
    }

    public function getDefaultOptions( array $options )
    {
    	return array(
                'data_class' => 'restoo\MainBundle\Entity\Job',
    	);
    }
    
    public function getName()
    {
        return 'job_adjust';
    }
}

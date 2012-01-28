<?php

namespace restoo\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * Form-Type for the team entity.
 * 
 * @author jochen
 */
class TeamType extends AbstractType
{
    public function buildForm( FormBuilder $builder, array $options )
    {
        $builder
	        ->add('title')
	        ->add('leader');
    }

    public function getName()
    {
        return 'restoo_mainbundle_teamtype';
    }
    
    public function getDefaultOptions( array $options )
    {
    	return array(
			'data_class' => 'restoo\MainBundle\Entity\Team',
    	);
    }
}

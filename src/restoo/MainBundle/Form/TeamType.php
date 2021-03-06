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
	        ->add('leader')
	        ->add('members');
    }

    public function getName()
    {
        return 'team';
    }
    
    public function getDefaultOptions( array $options )
    {
    	return array(
			'data_class' => 'restoo\MainBundle\Entity\Team',
    	);
    }
}

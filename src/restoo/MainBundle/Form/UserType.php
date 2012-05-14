<?php

namespace restoo\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserType extends AbstractType
{
	private $passwordRequired;
	
	/**
	 * @param boolean $passwordRequired false if password could be blank
	 */
	public function __construct( $passwordRequired=true ) 
	{
		$this->passwordRequired = $passwordRequired;
	}
	
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('firstname')
            ->add('lastname')
            ->add('email')
            ->add('password', 'repeated', array(
            	'type' => 'password',
            	'first_name' => 'Password',
            	'second_name' => 'Re-enter password',
            	'invalid_message' => "The passwords don't match!",
            	'required' => $this->passwordRequired
            ) )
            ->add('groups')
            ->add('team', null, array( 'required' => false) )
        ;
    }

    public function getName()
    {
        return 'user';
    }
    
    public function getDefaultOptions(array $options)
    {
    	return array(
            'data_class' => 'restoo\MainBundle\Entity\User',
    	);
    }
}

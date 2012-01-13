<?php

namespace restoo\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('firstname')
            ->add('lastname')
            ->add('email')
            ->add('password')
        ;
    }

    public function getName()
    {
        return 'restoo_mainbundle_usertype';
    }
    
    public function getDefaultOptions(array $options)
    {
    	return array(
            'data_class' => 'restoo\MainBundle\Entity\User',
    	);
    }
}

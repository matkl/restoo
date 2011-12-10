<?php 
namespace restoo\MainBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ProjectType extends AbstractType
{
    public function buildForm( FormBuilder $builder, array $options )
    {
        $builder->add('name');
        $builder->add('alias');
    }

    public function getName()
    {
        return 'project';
    }
}
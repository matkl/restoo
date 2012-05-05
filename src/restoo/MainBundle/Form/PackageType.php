<?php

namespace restoo\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

/**
 * Package Type
 * 
 * @author jochen <jochen.hilgers@gmail.com>
 */
class PackageType extends AbstractType
{
	/**
	 * see config.yml (restoo.date)
	 * @var array
	 */
	private $dateConfig;
	
	/**
	 *  
	 * @param array $dateConfig date config (see config.yml)
	 */
	public function __construct( $dateConfig )
	{
		$this->dateConfig = $dateConfig;	
	}
	
	/**
	 * (non-PHPdoc)
	 * @see Symfony\Component\Form.AbstractType::buildForm()
	 */
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('interval', 'choice', array(
            			'choices' => $this->createIntervalValues(),
            ))
        	->add('jobs', 'collection', array(	
        				'type' => new JobType(),
        				'allow_add' => true,
        				'allow_delete' => true,
        				'by_reference' => false, 
       		));
    }

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'package';
    }
    
    /**
     * generates array for the period dropdown
     *  
     * @throws InvalidArgumentException
     * @return array
     */
    private function createIntervalValues()
    {
    	$interval = $this->dateConfig['interval'];
    	$format = $this->dateConfig['format'][$interval];
    	
    	switch( $interval ) {
    		case 'week':
    			$date = new \DateTime( 'monday next week' );
    			$dateInterval = \DateInterval::createFromDateString( '1 week' );
    		break;
    		
    		case 'month':
    			$date = new \DateTime( 'first day of next month' );
    			$dateInterval = \DateInterval::createFromDateString( '1 month' );
    		break;
    		
    		default:
    			throw new InvalidArgumentException( "no valid interval defined" ); 
    		break;
    	}
    	
    	$values = array();
    	for( $i = 0; $i < 10; $i++ ) {
    		
    		$endDate = clone $date;
    		$endDate->add( $dateInterval );
    		$endDate->sub( \DateInterval::createFromDateString( '1 day' ) );
    		
    		$key = $date->format('Y-m-d').'_'.$endDate->format('Y-m-d');
    		$values[$key] = $date->format( $format );
    		
    		$date->add( $dateInterval );
    	}
    	return $values;
    }
}

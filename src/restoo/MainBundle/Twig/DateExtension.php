<?php 

namespace restoo\MainBundle\Twig;

use Twig_Extension;
use Twig_Filter_Method;
use Twig_Function_Method;

/**
 * Twig Extension for handling dates
 *
 * @author jochen <jochen.hilgers@gmail.com>
 */
class DateExtension extends Twig_Extension
{
	/**
	 * see config.yml (restoo.date)
	 * @var array
	 */
	private $dateConfig;
	
	/**
	 * @param array $dateConfig date config (see config.yml/restoo.date)
	 */
	public function __construct( $dateConfig )
	{
		$this->dateConfig = $dateConfig;	
	}
	
    /**
     * formatting a given period by global format rules
     * 
     * @param DateTime $startDate
     * @param DateTime $endDate
     * @return string
     */
    public function intervalFormat( $startDate, $endDate )
    {
    	$formats = $this->dateConfig['format'];
    	
    	$daysDiff = $startDate->diff( $endDate )->d;
    	if( $daysDiff == 6 ){
    		return $startDate->format($formats['week']);
    	} 
    	else if( $daysDiff <= 30 && $daysDiff >= 28 ) {
    		return $startDate->format( $formats['month'] );
    	}
    	else {
    		return $startDate->format($formats['date'])
    				.' - '.$endDate->format($formats['date']);
    	}
    }

    /**
     * (non-PHPdoc)
     * @see Twig_Extension::getFilters()
     */
    public function getFilters()
    {
    	return array(
                'interval' => new Twig_Filter_Method($this, 'intervalFormat'),
    	);
    }
    
    /**
     * (non-PHPdoc)
     * @see Twig_ExtensionInterface::getName()
     */
    public function getName()
    {
        return 'date_extension';
    }
}
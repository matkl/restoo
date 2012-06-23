<?php

namespace restoo\MainBundle\Controller;

use restoo\MainBundle\Service\DateService;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Planning controller.
 *
 * @Route("/planning")
 */
class PlanningController extends Controller
{
	/**
	 * @Route("/overview", name="planning_overview")
	 * @Template()
	 * @Secure(roles="ROLE_TL")
	 */
	public function overviewAction()
	{
		$user = $this->get('security.context')->getToken()->getUser();
		$jobRep = $this->getDoctrine()->getRepository('RestooMainBundle:Job');
		
		$releasedJobs = $jobRep->findReleasedForTeamLeader( $user );
		return array(
			'releasedJobs' => $releasedJobs
		);	
	}
	
	/**
	 * 
	 * @Route( "/week/{week}", name="planning_week")
	 * @Template()
	 * 
	 * @param integer $week number of the week
	 */
	public function showWeekAction( $week ){
		$week = (int)$week;
		
		if( $week < 1 
			|| $week > 53 
		){
			throw new InvalidArgumentException( "invalid week parameter (1-53)" );
		}
		
		$user = $this->get('security.context')->getToken()->getUser();
		$startDate = $this->get('restoo.date_service')->getFirstDayOfWeek( $week );
		$endDate = $this->get('restoo.date_service')->getLastDayOfWeek( $week );
		
		$jobRep = $this->getDoctrine()->getRepository('RestooMainBundle:Job');
		$jobs = $jobRep->findByUserAndInterval( $user, $startDate, $endDate );
		
		return array(
					'jobs' => $jobs,
					'week' => $week
				);
	}
}
<?php

namespace restoo\MainBundle\Controller;

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
}
<?php

namespace restoo\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Team controller.
 *
 * @Route("/team")
 */
class TeamController extends Controller
{
	/**
	 * @Route("/overview", name="team_overview")
	 * @Route("/", name="team")
	 * @Secure(roles="ROLE_TL")
	 * @Template()
	 */
	public function overviewAction(){
		$user = $this->get('security.context')->getToken()->getUser();
		
		$teams = $this->getDoctrine()
					  ->getRepository('RestooMainBundle:Team')
					  ->findAll();
		
		return array( 'teams' => $teams );
	}
}
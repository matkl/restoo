<?php

namespace restoo\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * 
 * @author jochen
 */
class DefaultController extends Controller
{
	/**
	 * @Route("/",name="home")
	 * @Template()
	 */
	public function indexAction()
	{
		/*$user = $this->get('security.context')->getToken()->getUser();
		
		$em = $this->getDoctrine()->getEntityManager();
		$repo = $em->getRepository('RestooMainBundle:Job');
		
		$assignedJobs = $repo->findByReceiver( $user->getId() );
		$createdJobs = $repo->findByReporter( $user->getId() );*/
		
		
		return array( 
				//'assignedJobs' => $assignedJobs,
				//'createdJobs' => $createdJobs,
		);
	}
	
	/**
	 * 
	 * @Route( "/help", name="help" )
	 * @Template()
	 */
	public function helpAction()
	{
		return array();
	}
	
}

<?php

namespace restoo\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use restoo\MainBundle\Entity\User;
/**
 * 
 */
class AdminController extends Controller
{
	/**
	 * @Route("/admin/",name="admin")
	 * @Template()
	 */
	public function indexAction()
	{
		return array();
	}
	
	/**
	 * 
	 * @Route( "/admin/create-user", name="adminCreateUser" )
	 * @Template()
	 */
	public function createUserAction()
	{
		$request = $this->getRequest();
		$username = $request->get('username');
		$password = $request->get('password');
		
		
		$user = new User();
		$user->setUsername( $username );
		
		$factory = $this->get( 'security.encoder_factory' );
		$encoder = $factory->getEncoder( $user );
		$password = $encoder->encodePassword( $password, $user->getSalt() );
		$user->setPassword( $password );
		
		$em = $this->getDoctrine()->getEntityManager();
		$em->persist( $user );
		$em->flush();
		
		return $this->redirect( $this->generateUrl( 'admin' ) );
	}
	
}

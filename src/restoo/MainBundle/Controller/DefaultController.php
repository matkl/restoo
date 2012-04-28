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
		return array();
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

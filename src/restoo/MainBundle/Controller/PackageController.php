<?php

namespace restoo\MainBundle\Controller;

use restoo\MainBundle\Entity\Package;
use restoo\MainBundle\Form\PackageType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * 
 */
class PackageController extends Controller
{
	/**
	 * @Route("/packages", name="packages")
	 * @Template()
	 */
	public function listAction()
	{
		$user = $this->get('security.context')->getToken()->getUser();
		$packages = $this->getDoctrine()
				->getRepository('RestooMainBundle:Package')
				->findByReporter( $user->getId() );
		
		return array(
			"packages" => $packages
		);
	}
	
	/**
	 * 
	 * @Route( "/package/new", name="package_new" )
	 * @Template()
	 */
	public function newAction()
	{
		$request = $this->getRequest();
		
		$form = $this->createForm( new PackageType() );
		
		if ($request->getMethod() == 'POST') 
		{
			$form->bindRequest($request);
			$user = $this->get('security.context')->getToken()->getUser();

			$package = $form->getData();
			$package->setReporter( $user );
			$package->setStatus( Package::STATUS_CREATED );
			
			if ($form->isValid())
			{
				$em = $this->getDoctrine()->getEntityManager();
				$em->persist( $package );
				$em->flush();
			}
		}
		
		return array(
			'form' => $form->createView()
		);
	}
}

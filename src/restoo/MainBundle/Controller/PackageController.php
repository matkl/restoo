<?php

namespace restoo\MainBundle\Controller;

use restoo\MainBundle\Entity\Package;
use restoo\MainBundle\Form\PackageType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Controller for managing packages.
 * 
 * @author jochen
 */
class PackageController extends Controller
{
	/**
	 * Action for listing all user packages.
	 *  
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
	 * Action for deleting an existing package.
	 * 
	 * @Route( "/package/delete/{id}", name="package_delete" )
	 * @Template()
	 */
	public function deleteAction( $id )
	{
		$em = $this->getDoctrine()->getEntityManager();
		$package = $em->getRepository('RestooMainBundle:Package')->find( $id );
		
		$em->remove( $package );
		$em->flush();
		
		return $this->redirect( $this->generateUrl( 'packages' ) );
	}
	
	/**
	 * action to update/create a package.
	 * 
	 * @Route( "/package/new", name="package_new" )
	 * @Route( "/package/edit/{id}", name="package_edit" )
	 * @Template()
	 */
	public function editAction( $id=null )
	{
		$em = $this->getDoctrine()->getEntityManager();
		
		//edit an existing package
		if( $id != null ) 
		{
			//@todo add error handling for unknown id
			$package = $em->getRepository('RestooMainBundle:Package')->find( $id );
			$formAction = $this->generateUrl( 'package_edit', array('id'=>$id) );
		}
		//create a new package
		else 
		{
			$package = null;
			$formAction = $this->generateUrl( 'package_new' );
		}
		
		$form = $this->createForm( new PackageType(), $package );
		
		//save or update the package
		if ($this->getRequest()->getMethod() == 'POST') 
		{
			$form->bindRequest( $this->getRequest() );

			//set default data for a new package
			if( $package == null )
			{
				$user = $this->get('security.context')->getToken()->getUser();
				$package = $form->getData();
				$package->setReporter( $user );
				$package->setStatus( Package::STATUS_CREATED );
			}
			
			if ($form->isValid())
			{
				$em = $this->getDoctrine()->getEntityManager();
				$em->persist( $package );
				$em->flush();
			}
		}
		
		return array(
			'form' => $form->createView(),
			'formAction' => $formAction,
		);
	}
}

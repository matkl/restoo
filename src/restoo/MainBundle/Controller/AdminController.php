<?php
//@todo try to combine new/edit-action for user
//@todo add delete action

namespace restoo\MainBundle\Controller;

use restoo\MainBundle\Form\UserType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use restoo\MainBundle\Entity\User;

/**
 * Controller for admin-actions
 * 
 * @author jochen
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
	 * Shows a list with all users
	 * 
	 * @Route( "/admin/user", name="admin_user" )
	 * @Template()
	 */
	public function userAction()
	{
		$users = $this->getDoctrine()
				->getRepository('RestooMainBundle:User')
				->findAll();
		
		return array( 'users' => $users );
	}
	
	/**
	 * @todo add description
	 * 
	 * @Route( "/admin/edit-user/{id}", name="admin_edit_user" )
	 * @Template()
	 */
	public function editUserAction( $id )
	{
		$user = $this->getDoctrine()
				->getRepository('RestooMainBundle:User')
				->find( $id );
		
		//@todo add error handling for invalid/unknown user-id
		$form = $this->createForm( new UserType(), $user );
		
		$request = $this->getRequest();
		if ($request->getMethod() == 'POST') 
		{
			//@todo add handling for password (overwrite or hide)
			$form->bindRequest( $request );
			if ($form->isValid())
			{
				$em = $this->getDoctrine()->getEntityManager();
				$em->persist( $form->getData() );
				$em->flush();
			}
		}
		
		return array(
			'form' => $form->createView(),
			'user' => $user
		);
	}
	
	/**
	 * @todo add description
	 * 
	 * @Route( "/admin/new-user", name="admin_new_user" )
	 * @Template()
	 */
	public function newUserAction()
	{
		$form = $this->createForm( new UserType() );
		
		$request = $this->getRequest();
		if ($request->getMethod() == 'POST') {
			
			$form->bindRequest($request);
			if ($form->isValid()) 
			{
				$user = $form->getData();

				//hash & salt the submitted password
				$factory = $this->get( 'security.encoder_factory' );
				$encoder = $factory->getEncoder( $user );
				$password = $encoder->encodePassword( 
						$user->getPassword(), $user->getSalt() );
				$user->setPassword( $password );
				
				$em = $this->getDoctrine()->getEntityManager();
				$em->persist( $user );
				$em->flush();
				
				return $this->redirect( $this->generateUrl( 'admin_edit_user', 
						array( 'id' =>  $user->getId() ) 
				) );
			}
		}
		
		return array( 
			'form' => $form->createView(),
		);
	}
	
}

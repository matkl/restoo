<?php

namespace restoo\MainBundle\Controller\Admin;


use restoo\MainBundle\Entity\Team;

use restoo\MainBundle\Form\TeamType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * 
 * @author jochen
 */
class TeamController extends Controller
{
	/**
	* Shows a list with all existing teams
	*
	* @Route( "/admin/teams", name="admin_teams" )
	* @Template()
	*/
	public function indexAction()
	{
		$teams = $this->getDoctrine()
				->getRepository('RestooMainBundle:Team')
				->findAll();
	
		return array( 'teams' => $teams );
	}
	
	/**
	 *
	 * @Route( "/admin/team/new", name="admin_team_new" )
	 * @Route( "/admin/team/edit/{id}", name="admin_team_edit" )
	 * @Template()
	 */
	public function editAction( $id=null )
	{
		$em = $this->getDoctrine()->getEntityManager();
	
		//edit an existing team
		if( $id != null )
		{
			//@todo add error handling for unknown id
			$team = $em->getRepository('RestooMainBundle:Team')->find( $id );
			$formAction = $this->generateUrl( 'admin_team_edit', array( 'id' => $id ) );
		}
		//create a new team
		else
		{
			$team = new Team();
			$formAction = $this->generateUrl( 'admin_team_new' );
		}
	
		$form = $this->createForm( new TeamType(), $team );
	
		//save or update the job
		if ($this->getRequest()->getMethod() == 'POST')
		{
				
			$form->bindRequest( $this->getRequest() );
			//$team = $form->getData();
				
			if ($form->isValid())
			{
				$em = $this->getDoctrine()->getEntityManager();
				$em->persist( $team );
				$em->flush();
			}
		}
	
		return array(
				'form' => $form->createView(),
				'formAction' => $formAction
		);
	}
	
	/**
	 *
	 * @Route( "/admin/team/delete/{id}", name="admin_team_delete" )
	 * @Template()
	 */
	public function deleteAction( $id )
	{
		$em = $this->getDoctrine()->getEntityManager();
		$team = $em->getRepository('RestooMainBundle:Team')->find( $id );
		
		$em->remove( $team );
		$em->flush();
		
		return $this->redirect( $this->generateUrl( 'admin_teams' ) );
	}
}
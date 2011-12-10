<?php

namespace restoo\MainBundle\Controller;

use restoo\MainBundle\Form\Type\ProjectType;

use restoo\MainBundle\Entity\Project;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * 
 * @author jochen
 */
class ProjectController extends Controller
{
	/**
	 * @Route("/projects", name="projects")
	 * @Template()
	 */
	public function listAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		$projects = $em->getRepository('RestooMainBundle:Project')->findAll();
		
		return array(
			"projects" => $projects
		);
	}
	
	/**
	 * @Route("/project/show/{id}", name="projectShow")
	 * @Template() 
	 */
	public function showAction( $id )
	{
		$em = $this->getDoctrine()->getEntityManager();
		$project = $em->getRepository('RestooMainBundle:Project')->find( $id );
		
		return array(
			'project' => $project
		);
	}
	
	/**
	 * @Route("/project/delete{id}", name="projectDelete")
	 * @Template();
	 */
	public function deleteAction( $id )
	{
		$em = $this->getDoctrine()->getEntityManager();
		$project = $em->getRepository('RestooMainBundle:Project')->find( $id );
		
		$em->remove( $project );
		$em->flush();
		
		return $this->redirect( $this->generateUrl( 'projects' ) );
	}
	
	/**
	* @Route("/project/new", name="projectNew")
	* @Template()
	*/
	public function newAction()
	{
		$request = $this->getRequest();
		$user = $this->get('security.context')->getToken()->getUser();
		
		$project = new Project();
		$project->setManager( $user );
		
		$form = $this->createForm(new ProjectType(), $project);
		
		if ($request->getMethod() == 'POST') {
			
			$form->bindRequest($request);
			
			if ($form->isValid()){

				$em = $this->getDoctrine()->getEntityManager();
				$em->persist( $project );
				$em->flush();
		
				return $this->redirect( $this->generateUrl( 'projects' ) );
			}
		}
		
		return array(
			'form' => $form->createView()
		);
	}
}

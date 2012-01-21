<?php

namespace restoo\MainBundle\Controller;

use restoo\MainBundle\Form\JobType;

use restoo\MainBundle\Entity\Job;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * 
 * @author jochen
 */
class JobController extends Controller
{
	/**
	 * @Route("/jobs", name="jobs")
	 * @Template()
	 */
	public function listAction()
	{
		$em = $this->getDoctrine()->getEntityManager();
		//@todo filter by current user (or team)
		$jobs = $em->getRepository('RestooMainBundle:Job')->findAll();
		
		return array(
			"jobs" => $jobs
		);
	}
	
	/**
	 * @Route("/job/view/{id}", name="job_show")
	 * @Template() 
	 */
	public function showAction( $id )
	{
		$em = $this->getDoctrine()->getEntityManager();
		$job = $em->getRepository('RestooMainBundle:Job')->find( $id );
		
		return array(
			'job' => $job
		);
	}
	
	/**
	 * Action for deleting a single job.
	 * 
	 * @Route("/job/delete/{id}", name="job_delete")
	 * @Template();
	 */
	public function deleteAction( $id )
	{
		$em = $this->getDoctrine()->getEntityManager();
		$job = $em->getRepository('RestooMainBundle:Job')->find( $id );
		
		$em->remove( $job );
		$em->flush();
		
		return $this->redirect( $this->generateUrl( 'jobs' ) );
	}
	
	/**
	 * 
	 * @Route("/job/new", name="job_new")
	 * @Route("/job/edit/{id}", name="job_edit")
	 * @Template()
	 */
	public function editAction( $id = null )
	{
		$em = $this->getDoctrine()->getEntityManager();

		//edit an existing job
		if( $id != null )
		{
			//@todo add error handling for unknown id
			$job = $em->getRepository('RestooMainBundle:Job')->find( $id );
			$formAction = $this->generateUrl( 'job_edit', array( 'id' => $id ) );
		}
		//create a new job
		else
		{
			$job = null;
			$formAction = $this->generateUrl( 'job_new' );
		}
		
		$form = $this->createForm( new JobType(), $job );
		
		//save or update the job
		if ($this->getRequest()->getMethod() == 'POST') 
		{
			
			$form->bindRequest( $this->getRequest() );
			
			//set default data for a new job
			if( $job == null )
			{
				$user = $this->get('security.context')->getToken()->getUser();
				$job = $form->getData();
				$job->setReporter( $user );
			}
			

			if ($form->isValid())
			{
				$em = $this->getDoctrine()->getEntityManager();
				$em->persist( $job );
				$em->flush();
			}
		}
		
		return array(
			'form' => $form->createView(),
			'formAction' => $formAction
		);
	}
}

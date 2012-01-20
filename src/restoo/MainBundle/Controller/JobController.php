<?php

namespace restoo\MainBundle\Controller;

use restoo\MainBundle\Form\JobType;

use restoo\MainBundle\Entity\Job;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * 
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
	* @Route("/job/new", name="job_new")
	* @Template()
	*/
	public function newAction()
	{
		$request = $this->getRequest();
		
		$form = $this->createForm(new JobType() );
		
		if ($request->getMethod() == 'POST') {
			
			$form->bindRequest($request);
			
			$job = new Job();
			
			$user = $this->get('security.context')->getToken()->getUser();

			$job = $form->getData();
			$job->setReporter( $user );
			
			if ($form->isValid()){

				$em = $this->getDoctrine()->getEntityManager();
				$em->persist( $job );
				$em->flush();
		
				return $this->redirect( $this->generateUrl( 'jobs' ) );
			}
		}
		
		return array(
			'form' => $form->createView()
		);
	}
}

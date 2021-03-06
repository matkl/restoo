<?php

namespace restoo\MainBundle\Controller;

use restoo\MainBundle\Form\JobAdjustType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use restoo\MainBundle\Entity\Job;
use restoo\MainBundle\Form\JobType;

/**
 * Job controller.
 *
 * @Route("/job")
 */
class JobController extends Controller
{
	/**
	 *
	 * @Route("/overview", name="job_overview")
	 * @Template()
	 */
	public function overviewAction()
	{
		return array();
	}
	
	/**
	 *
	 * @Route("/{id}/accept", name="job_accept")
	 * @Template()
	 */
	public function acceptAction( $id )
	{
		$em = $this->getDoctrine()->getEntityManager();
		$entity = $em->getRepository('RestooMainBundle:Job')->find($id);
		
		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Job entity.');
		}
		
		if( $entity->getStatus() == Job::STATUS_RELEASED ) {
			$entity->accept();
		
			$em->persist($entity);
			$em->flush();
		}
		else {
			//TODO throw exception
		}
		
		return $this->forward('RestooMainBundle:Planning:overview' );
	}
	/**
	 *
	 * @Route("/{id}/reject", name="job_reject")
	 * @Template()
	 */
	public function rejectAction( $id )
	{
		$em = $this->getDoctrine()->getEntityManager();
		$entity = $em->getRepository('RestooMainBundle:Job')->find($id);
		
		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Job entity.');
		}
		
		if( $entity->getStatus() == Job::STATUS_RELEASED ) {
			$entity->reject();
		
			$em->persist($entity);
			$em->flush();
		}
		else {
			//TODO throw exception
		}
		
		return $this->forward('RestooMainBundle:Planning:overview' );
	}
	
	/**
	 *
	 * @Route("/{id}/adjust", name="job_adjust")
	 * @Template()
	 */
	public function adjustAction( $id )
	{
		$em = $this->getDoctrine()->getEntityManager();
		$job = $em->getRepository('RestooMainBundle:Job')->find($id);
		
		if (!$job) {
			throw $this->createNotFoundException('Unable to find Job entity.');
		}
		$form = $this->createForm( new JobAdjustType(), $job );
		
		if ($this->getRequest()->getMethod() == 'POST'){
			$form->bindRequest( $this->getRequest() );
			if ($form->isValid()) {
				$em->persist($job);
				$em->flush();
			}
		}
		
		return array(
					'form' => $form->createView(),
					'job' => $job,
				);
	}
	
    /**
     * Lists all Job entities.
     *
     * @Route("/", name="job")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('RestooMainBundle:Job')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Job entity.
     *
     * @Route("/{id}/show", name="job_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('RestooMainBundle:Job')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Job entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }
    
    /**
     * Displays a form to create a new Job entity.
     *
     * @Route("/new", name="job_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Job();
        $form   = $this->createForm(new JobType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Job entity.
     *
     * @Route("/create", name="job_create")
     * @Method("post")
     * @Template("RestooMainBundle:Job:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Job();
        $request = $this->getRequest();
        $form    = $this->createForm(new JobType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('job_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Job entity.
     *
     * @Route("/{id}/edit", name="job_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('RestooMainBundle:Job')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Job entity.');
        }

        $editForm = $this->createForm(new JobType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Job entity.
     *
     * @Route("/{id}/update", name="job_update")
     * @Method("post")
     * @Template("RestooMainBundle:Job:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('RestooMainBundle:Job')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Job entity.');
        }

        $editForm   = $this->createForm(new JobType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('job_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Job entity.
     *
     * @Route("/{id}/delete", name="job_delete")
     */
    public function deleteAction($id)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	$entity = $em->getRepository('RestooMainBundle:Job')->find($id);
    	if (!$entity) {
    		throw $this->createNotFoundException('Unable to find Job entity.');
    	}
    	
    	$em->remove($entity);
    	$em->flush();
    	
        return $this->redirect($this->generateUrl('job'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

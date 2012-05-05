<?php

namespace restoo\MainBundle\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use restoo\MainBundle\Entity\Package;

/**
 * Package controller.
 *
 * @Route("/package")
 */
class PackageController extends Controller
{
	/**
	 * @Route("/overview", name="package_overview")
	 * @Route("/", name="package")
	 * @Template()
	 */
	public function overviewAction(){
		
		$user = $this->get('security.context')->getToken()->getUser();
		$packageRep = $this->getDoctrine()
				->getRepository('RestooMainBundle:Package');
		
		$createdPackages = $packageRep->findBy( array( 
					'reporter' => $user->getId(), 
					'status' => Package::STATUS_CREATED ) );
		$releasedPackages = $packageRep->findBy( array( 
					'reporter' => $user->getId(), 
					'status' => Package::STATUS_RELEASED ) );
		$confirmedPackages = $packageRep->findBy( array( 
					'reporter' => $user->getId(), 
					'status' => Package::STATUS_CONFIRMED ) );
		
		return array(
			'createdPackages' => $createdPackages, 
			'releasedPackages' => $releasedPackages, 
			'confirmedPackages' => $confirmedPackages, 
		);
		
	}
	
    /**
     * finds and releases a package
     * 
     * @param integer $id
     * @throws NotFoundHttpException
     * @Route("/{id}/release", name="package_release")
     */
    public function releaseAction( $id ) {
    	$em = $this->getDoctrine()->getEntityManager();
    	$package = $em->getRepository('RestooMainBundle:Package')->find($id);
    	
		if (!$package) {
			throw $this->createNotFoundException('Unable to find Package entity.');
		}
		
		try {
			$package->release();
			$em->persist($package);
			$em->flush();
		} catch (\Exception $e) {
			//TODO handle error
		}
		
		return $this->forward('RestooMainBundle:Package:overview' );
    }
    
    /**
     * cancel a released/confirmed package
     * 
     * @param integer $id
     * @throws NotFoundHttpException
     * @Route("/{id}/cancel", name="package_cancel")
     */
    public function cancelAction( $id ) {
    	$em = $this->getDoctrine()->getEntityManager();
    	$package = $em->getRepository('RestooMainBundle:Package')->find($id);
    	
		if (!$package) {
			throw $this->createNotFoundException('Unable to find Package entity.');
		}
		
		try {
			$package->cancel();
			$em->persist($package);
			$em->flush();
		} catch (\Exception $e) {
			//TODO handle error
		}
		
		return $this->forward('RestooMainBundle:Package:overview' );
    }
    
    /**
     * Finds and displays a Package entity.
     *
     * @Route("/{id}/show", name="package_show")
     * @Template()
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('RestooMainBundle:Package')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Package entity.');
        }


        return array(
            'entity'      => $entity );
    }

    /**
     * Displays a form to create a new Package entity.
     *
     * @Route("/new", name="package_new")
     * @Template()
     */
    public function newAction(){
        
    	$package = new Package();
        $form   = $this->createForm( $this->get('restoo.packagetype'), $package );

        return array(
            'entity' => $package,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Package entity.
     *
     * @Route("/create", name="package_create")
     * @Method("post")
     * @Template("RestooMainBundle:Package:new.html.twig")
     */
    public function createAction(){
    	$user = $this->get('security.context')->getToken()->getUser();
        
    	$package  = new Package();
        $package->setReporter( $user );
        
        $request = $this->getRequest();
        $form    = $this->createForm( $this->get('restoo.packagetype'), $package );
        $form->bindRequest($request);

        if ($form->isValid()) {
        	
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($package);
            $em->flush();

            return $this->redirect( $this->generateUrl('package_edit', array('id' => $package->getId())));
            
        }

        return array(
            'entity' => $package,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Package entity.
     *
     * @Route("/{id}/edit", name="package_edit")
     * @Template()
     */
    public function editAction($id){
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('RestooMainBundle:Package')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Package entity.');
        }

        $editForm = $this->createForm($this->get('restoo.packagetype'), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Package entity.
     *
     * @Route("/{id}/update", name="package_update")
     * @Method("post")
     * @Template("RestooMainBundle:Package:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('RestooMainBundle:Package')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Package entity.');
        }

        $editForm   = $this->createForm( $this->get('restoo.packagetype'), $entity);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) 
        {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('package_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Package entity.
     *
     * @Route("/{id}/delete", name="package_delete")
     */
    public function deleteAction($id)
    {
		$em = $this->getDoctrine()->getEntityManager();
		$entity = $em->getRepository('RestooMainBundle:Package')->find($id);
		if (!$entity) {
			throw $this->createNotFoundException('Unable to find Package entity.');
		}

		$em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('package'));
    }
}

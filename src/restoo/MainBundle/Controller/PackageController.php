<?php

namespace restoo\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use restoo\MainBundle\Entity\Package;
use restoo\MainBundle\Form\PackageType;

/**
 * Package controller.
 *
 * @Route("/package")
 */
class PackageController extends Controller
{
	/**
	 * @Route("/overview", name="package_overview")
	 * @Template()
	 */
	public function overviewAction() {
		
		$user = $this->get('security.context')->getToken()->getUser();
		$packageRep = $this->getDoctrine()->getRepository('RestooMainBundle:Package');
		return array(
			'packages' => $packageRep->findByReporter( $user->getId() )
		);
		
	}
	
    /**
     * Lists all Package entities.
     *
     * @Route("/", name="package")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $packages = $em->getRepository('RestooMainBundle:Package')->findAll();

        return array('packages' => $packages);
    }

    /**
     * Finds and displays a Package entity.
     *
     * @Route("/{id}/show", name="package_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('RestooMainBundle:Package')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Package entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Package entity.
     *
     * @Route("/new", name="package_new")
     * @Template()
     */
    public function newAction()
    {
    	
        
    	$package = new Package();
        $form   = $this->createForm( new PackageType(), $package );

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
    public function createAction()
    {
    	$user = $this->get('security.context')->getToken()->getUser();
        
    	$package  = new Package();
        $package->setReporter( $user );
        
        $request = $this->getRequest();
        $form    = $this->createForm(new PackageType(), $package);
        $form->bindRequest($request);

        if ($form->isValid()) {
        	
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($package);
            $em->flush();

            return $this->redirect( $this->generateUrl('package_show', array('id' => $package->getId())));
            
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
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('RestooMainBundle:Package')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Package entity.');
        }

        $editForm = $this->createForm(new PackageType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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

        $editForm   = $this->createForm(new PackageType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

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
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Package entity.
     *
     * @Route("/{id}/delete", name="package_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('RestooMainBundle:Package')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Package entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('package'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

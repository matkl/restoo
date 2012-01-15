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
class JobPackageController extends Controller
{
	/**
	 * @Route("/packages", name="job_packages")
	 * @Template()
	 */
	public function listAction()
	{
		return array(
		);
	}
}

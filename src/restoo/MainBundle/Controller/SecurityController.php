<?php 
namespace restoo\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SecurityController extends Controller
{
	/**
	 * 
	 * @Route( "/login", name="login" )
	 * @Template()
	 */
	public function loginAction()
	{
		$request = $this->getRequest();
		$session = $request->getSession();
		
		// get the login error if there is one
		if ($request->attributes->has( SecurityContext::AUTHENTICATION_ERROR ) ) {
			$error = $request->attributes->get( SecurityContext::AUTHENTICATION_ERROR );
		} else {
			$error = $session->get( SecurityContext::AUTHENTICATION_ERROR );
		}
		
		return array( 
			'error' => $error,
			'last_username' => $session->get( SecurityContext::LAST_USERNAME )
		);
	}

	/**
	 * 
	 * @Route( "/logout", name="logout" )
	 * @Template()
	 */
        public function logoutAction()
        {
            $session = $this->getRequest()->getSession();
            $session->clear();
            return $this->redirect( $this->generateUrl( 'home' ) );
        }
	
	/**
	 *
	 * @Route( "/login-check", name="loginCheck" )
	 * @Template()
	 */
	public function loginCheckAction()
	{
	}
	
}
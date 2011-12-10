<?php 

namespace restoo\MainBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 * 
 * TODO implement serializable interface
 */
class User implements UserInterface /*implements Serializable*/ 
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $username;
	
	/**
	 * @ORM\Column(type="string", length=88)
	 */
	protected $password;
	
	/**
	 * @ORM\Column(type="string", length=40)
	 */
	protected $salt;
	
	protected $roles = array();
	
	/**
	* Get id
	*
	* @return integer
	*/
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * Returns the password used to authenticate the user.
	 *
	 * @return string The password
	 */
	public function getPassword()
	{
		return $this->password;
	}
	
	public function setPassword( $password )
	{
		$this->password = $password;
	}
	
	/**
	 * Returns the salt.
	 *
	 * @return string The salt
	 */
	public function getSalt()
	{
		if( $this->salt == null ){
			$this->salt = sha1( uniqid().rand() );
		}
		return $this->salt;
	}
	
	
	/**
	 * Returns the username used to authenticate the user.
	 *
	 * @return string The username
	 */
	public function getUsername()
	{
		return $this->username;
	}
	
	public function setUsername( $username )
	{
		$this->username = $username;
	}
	
	/**
	 * Returns the roles granted to the user.
	 *
	 * @return Role[] The user roles
	 */
	public function getRoles()
	{
		return $this->roles;
	}
	
	/**
	 * Removes sensitive data from the user.
	 *
	 * @return void
	 */
	public function eraseCredentials()
	{
		
	}
	
	/**
	 * The equality comparison should neither be done by referential equality
	 * nor by comparing identities (i.e. getId() === getId()).
	 *
	 * However, you do not need to compare every attribute, but only those that
	 * are relevant for assessing whether re-authentication is required.
	 *
	 * @param UserInterface $user
	 * @return Boolean
	 */
	public function equals(UserInterface $user) 
	{
		
	}
}
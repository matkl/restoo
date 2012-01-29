<?php 

namespace restoo\MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

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
	
	/**
	 * @ORM\Column(type="string", length=50)
	 */
	protected $firstname;
	
	/**
	 * @ORM\Column(type="string", length=50)
	 */
	protected $lastname;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $email;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Team", inversedBy="members")
	 * @ORM\JoinColumn(name="team_id", referencedColumnName="id")
	 */
	protected $team;
	
	/**
	 * @ORM\ManyToMany(targetEntity="Group", inversedBy="users")
	 */
	protected $groups = array();
	
	/**
	 * @Gedmo\Timestampable(on="create")
	 * @ORM\Column(type="datetime")
	 */
	protected $created;
	
	/**
	 * @ORM\Column(type="datetime")
	 * @Gedmo\Timestampable(on="update")
	 */
	protected $updated;
	
	public function __construct()
	{
		$this->groups = new ArrayCollection();
	}
	
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

    /**
     * Set salt
     *
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * Returns the roles granted to the user.
     *
     * @return Role[] The user roles
     */
    public function getRoles()
    {
    	return $this->groups->toArray();
    }
    
    public function __toString()
    {
    	return $this->firstname." ".$this->lastname;
    }

    /**
     * Get groups
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Add groups
     *
     * @param restoo\MainBundle\Entity\Group $groups
     */
    public function addGroup(\restoo\MainBundle\Entity\Group $groups)
    {
        $this->groups[] = $groups;
    }
    
	public function setGroups( ArrayCollection $groups )
    {
    	foreach( $groups as $group )
    	{
    		$group->addUser( $this );
    		$this->addGroup( $group );
    	}
    }

    /**
     * Set created
     *
     * @param datetime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get created
     *
     * @return datetime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param datetime $updated
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    }

    /**
     * Get updated
     *
     * @return datetime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set team
     *
     * @param restoo\MainBundle\Entity\Team $team
     */
    public function setTeam(\restoo\MainBundle\Entity\Team $team)
    {
        $this->team = $team;
    }

    /**
     * Get team
     *
     * @return restoo\MainBundle\Entity\Team 
     */
    public function getTeam()
    {
        return $this->team;
    }
}
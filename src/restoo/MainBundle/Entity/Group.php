<?php 

namespace restoo\MainBundle\Entity;

use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="groups")
 */
class Group implements RoleInterface 
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/** 
	 * @ORM\Column(name="name", type="string", length=30) 
	 */
	private $name;
	
	/** 
	 * @ORM\Column(name="role", type="string", length=20, unique=true) 
	 */
	private $role;
	
	/** 
	 * @ORM\ManyToMany(targetEntity="User", mappedBy="groups") 
	 */
	private $users;
	
	public function __construct()
	{
		$this->users = new ArrayCollection();
	}
	
	/** 
	 * @see RoleInterface 
	 */
	public function getRole()
	{
		return $this->role;
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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set role
     *
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * Add users
     *
     * @param restoo\MainBundle\Entity\User $users
     */
    public function addUser(\restoo\MainBundle\Entity\User $users)
    {
        $this->users[] = $users;
    }

    /**
     * Get users
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
    
    public function __toString()
    {
    	return $this->name;
    }
}
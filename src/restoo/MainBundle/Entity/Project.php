<?php 

namespace restoo\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * 
 * @ORM\Entity
 * @ORM\Table(name="projects")
 */
class Project
{
	/**
	 * @ORM\id
	 * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
	 */
    protected $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    protected $alias;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="projects")
     * @ORM\JoinColumn(name="manager_user_id", referencedColumnName="id")
     */
    protected $manager;

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
     * Set alias
     *
     * @param string $alias
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
    }

    /**
     * Get alias
     *
     * @return string 
     */
    public function getAlias()
    {
        return $this->alias;
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
     * Set manager
     *
     * @param restoo\MainBundle\Entity\User $manager
     */
    public function setManager(\restoo\MainBundle\Entity\User $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Get manager
     *
     * @return restoo\MainBundle\Entity\User 
     */
    public function getManager()
    {
        return $this->manager;
    }
}
<?php 

namespace restoo\MainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="teams")
 * 
 */
class Team 
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
	protected $title;
	
	/**
	 * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumn(name="leader_user_id", referencedColumnName="id")
	 */
	protected $leader;
	
	/**
	 * @ORM\OneToMany(targetEntity="User", mappedBy="team")
	 */
	protected $members;
	
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
        $this->members = new ArrayCollection();
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
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
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
     * Add members
     *
     * @param restoo\MainBundle\Entity\User $members
     */
    public function addMember(\restoo\MainBundle\Entity\User $member)
    {
        $this->members[] = $member;
    }
    
    /**
     * Get members
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getMembers()
    {
        return $this->members;
    }
    
    public function setMembers( ArrayCollection $members )
    {
    	foreach( $members as $user ) 
    	{
    		$this->addMember( $user );	
    		$user->setTeam( $this );
    	}
    }

    /**
     * Set leader
     *
     * @param restoo\MainBundle\Entity\User $leader
     */
    public function setLeader(\restoo\MainBundle\Entity\User $leader)
    {
        $this->leader = $leader;
    }

    /**
     * Get leader
     *
     * @return restoo\MainBundle\Entity\User 
     */
    public function getLeader()
    {
        return $this->leader;
    }

    /**
     * Add members
     *
     * @param restoo\MainBundle\Entity\User $members
     */
    public function addUser(\restoo\MainBundle\Entity\User $members)
    {
        $this->members[] = $members;
    }
    
    public function __toString()
    {
    	return $this->getTitle();
    }
}
<?php 

namespace restoo\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="jobs")
 * 
 */
class Job 
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string", length=15)
	 */
	protected $alias;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $title;
	
	/**
	 * @ORM\Column(type="string", length=100)
	 */
	protected $description;
	
	/**
	 * @ORM\Column(type="float")
	 */
	protected $effort;
	
	/**
	* @ORM\ManyToOne(targetEntity="User", inversedBy="jobs")
	* @ORM\JoinColumn(name="reporter_user_id", referencedColumnName="id")
	*/
	protected $reporter;
	
	/**
	 * @ORM\ManyToOne(targetEntity="User", inversedBy="jobs")
	 * @ORM\JoinColumn(name="receiver_user_id", referencedColumnName="id")
	 */
	protected $receiver;
	
	/**
	 * @Gedmo\Timestampable(on="create")
	 * @ORM\Column(type="date")
	 */
	private $created;
	
	/**
	 * @ORM\Column(type="datetime")
	 * @Gedmo\Timestampable(on="update")
	 */
	private $updated;
	

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
     * Set description
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set effort
     *
     * @param float $effort
     */
    public function setEffort($effort)
    {
        $this->effort = $effort;
    }

    /**
     * Get effort
     *
     * @return float 
     */
    public function getEffort()
    {
        return $this->effort;
    }

    /**
     * Set created
     *
     * @param date $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * Get created
     *
     * @return date 
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
     * Set reporter
     *
     * @param restoo\MainBundle\Entity\User $reporter
     */
    public function setReporter(\restoo\MainBundle\Entity\User $reporter)
    {
        $this->reporter = $reporter;
    }

    /**
     * Get reporter
     *
     * @return restoo\MainBundle\Entity\User 
     */
    public function getReporter()
    {
        return $this->reporter;
    }

    /**
     * Set receiver
     *
     * @param restoo\MainBundle\Entity\User $receiver
     */
    public function setReceiver(\restoo\MainBundle\Entity\User $receiver)
    {
        $this->receiver = $receiver;
    }

    /**
     * Get receiver
     *
     * @return restoo\MainBundle\Entity\User 
     */
    public function getReceiver()
    {
        return $this->receiver;
    }
}
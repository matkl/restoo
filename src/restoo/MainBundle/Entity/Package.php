<?php 

namespace restoo\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * 
 * @ORM\Entity
 * @ORM\Table(name="packages")
 */
class Package 
{
	const STATUS_CREATED = 'created';	
	const STATUS_RELEASED = 'released';
	const STATUS_CONFIRMED = 'confirmed';
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="date")
	 */
	protected $startDate;
	
	/**
	 * @ORM\Column(type="date")
	 */
	protected $endDate;
	
	/** 
	 * @ORM\Column(type="string"); 
	 */
    protected $status;
	
    /**
    * @ORM\ManyToOne(targetEntity="User", inversedBy="packages")
    * @ORM\JoinColumn(name="reporter_user_id", referencedColumnName="id")
    */
    protected $reporter;
    
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
     * Set startDate
     *
     * @param date $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * Get startDate
     *
     * @return date 
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param date $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * Get endDate
     *
     * @return date 
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set status
     *
     * @param string $status
     */
    public function setStatus($status)
    {
    	if (!in_array($status, array( 
    			self::STATUS_CREATED, 
    			self::STATUS_CONFIRMED, 
    			self::STATUS_RELEASED ) ) ) 
    	{
    		throw new \InvalidArgumentException("Invalid status");
    	}
    	
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
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
}
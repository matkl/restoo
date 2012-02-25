<?php 

namespace restoo\MainBundle\Entity;

use Doctrine\ORM\PersistentCollection;

use Doctrine\Common\Collections\ArrayCollection;

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
	 * @ORM\Column(type="string");
	 */
	protected $title;
	
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
     * @ORM\OneToMany(targetEntity="Job", mappedBy="package", cascade={"persist"}, orphanRemoval=true )
     */
    protected $jobs;
    
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
		$this->startDate = new \DateTime('Monday next week');
		$this->endDate = new \DateTime('Friday next week');
		$this->status = self::STATUS_CREATED;
		$this->jobs = new ArrayCollection();
	}
	
	/**
	 * 
	 * return string
	 */
	public function __toString()
	{
		return $this->getTitle();
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
    
    /**
     * Add jobs
     *
     * @param restoo\MainBundle\Entity\Job $jobs
     */
    public function addJob(\restoo\MainBundle\Entity\Job $jobs)
    {
        $this->jobs[] = $jobs;
    }

    /**
     * Set Jobs
     * 
     * @param PersistentCollection $jobs
     */
    public function setJobs( PersistentCollection $jobs )
    {
    	foreach( $jobs as $job )
    	{
    		$job->setPackage( $this );
    		$job->setReporter( $this->getReporter() );
    		$this->addJob( $job );
    	}
    }
    
    /**
     * Get jobs
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getJobs()
    {
        return $this->jobs;
    }
    
    public function getEffort()
    {
    	$sum = 0;
    	foreach( $this->getJobs() as $job )
    	{
    		$sum += $job->getEffort();
    	}
    	return $sum;
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
}
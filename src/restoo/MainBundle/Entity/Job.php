<?php 

namespace restoo\MainBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity
 * @ORM\Table(name="jobs")
 * @ORM\Entity(repositoryClass="restoo\MainBundle\Repository\JobRepository")
 */
class Job 
{
	const STATUS_CREATED = 'created';
	const STATUS_RELEASED = 'released';
	const STATUS_REJECTED = 'rejected';
	const STATUS_ACCEPTED = 'accepted';
	
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
	 * @ORM\Column(type="string", length=50)
	 */
	protected $title;
	
	/**
	 * @ORM\Column(type="string", length=150, nullable=true)
	 */
	protected $description;
	
	/**
	 * @ORM\Column(type="float")
	 */
	protected $effort;
	
	/**
	 * @ORM\Column(type="date", nullable=true)
	 */
	protected $deadline;
	
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
	 * @ORM\ManyToOne(targetEntity="Package", inversedBy="jobs")
	 * @ORM\JoinColumn(name="package_id", referencedColumnName="id")
	 */
	protected $package;

	/**
	 * @ORM\Column(type="string", length=20)
	 */
	protected $status = self::STATUS_CREATED;
	
	/**
	 * @Gedmo\Timestampable(on="create")
	 * @ORM\Column(type="datetime")
	 */
	private $created;
	
	/**
	 * @ORM\Column(type="datetime")
	 * @Gedmo\Timestampable(on="update")
	 */
	private $updated;

	public function __construct()
	{
			
	}
	
	public function release(){
		
		if( $this->getStatus() == self::STATUS_CREATED ) {
			$this->setStatus( self::STATUS_RELEASED );
		}
		else {
			throw new \Exception( 'invalid operation, job not in state "created"' );
		}
	}
	
	
	public function accept(){
		if( $this->getStatus() == self::STATUS_RELEASED ) {
			$this->setStatus( self::STATUS_ACCEPTED );
			$this->getPackage()->update();
		}
		else {
			throw new \Exception( 'invalid operation, job not in state "released"' );
		}
	}
	
	public function reject(){
		if( $this->getStatus() == self::STATUS_RELEASED ) {
			$this->setStatus( self::STATUS_REJECTED );
			$this->getPackage()->update();
		}
		else {
			throw new \Exception( 'invalid operation, job not in state "released"' );
		}
	}
	
	/**
	 * 
	 * return string
	 */	
	public function __toString()
	{
		return $this->getAlias().': '.$this->getTitle();
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

    /**
     * Set package
     *
     * @param restoo\MainBundle\Entity\Package $package
     */
    public function setPackage(\restoo\MainBundle\Entity\Package $package)
    {
        $this->package = $package;
    }

    /**
     * Get package
     *
     * @return restoo\MainBundle\Entity\Package 
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * Set deadline
     *
     * @param date $deadline
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
    }

    /**
     * Get deadline
     *
     * @return date 
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * Set status
     *
     * @param string $status
     */
    public function setStatus($status)
    {
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
     * true if this job was rejected
     * 
     * @return boolean
     */
    public function isRejected(){
    	return ( $this->getStatus() == self::STATUS_REJECTED );
    }
    
    /**
     * true if this job was accepted
     *  
     * @return boolean
     */
    public function isAccepted(){
    	return ( $this->getStatus() == self::STATUS_ACCEPTED );
    }
}
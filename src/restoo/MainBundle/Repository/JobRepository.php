<?php 
namespace restoo\MainBundle\Repository;

use restoo\MainBundle\Entity\User;

use restoo\MainBundle\Entity\Job;

use restoo\MainBundle\Entity\Package;

use Doctrine\ORM\EntityRepository;

class JobRepository extends EntityRepository
{
	/**
	 * searches the db for jobs in released packages for
	 * the given team leader
	 * 
	 * @param User $user
	 */
	public function findReleasedForTeamLeader( $user )
	{
		$em = $this->getEntityManager();
		$query = $em->createQuery(
	    		'SELECT job 
	    		 FROM RestooMainBundle:Job job
	    		 JOIN job.receiver user
	    		 JOIN job.package package
	    		 JOIN user.team team
	    		 WHERE team.leader = :leader
	    		 AND package.status = :package_status
	    		 AND job.status = :job_status
	    		 ORDER BY package.startDate
    		')
			->setParameter('leader', $user->getId() )
			->setParameter('package_status', Package::STATUS_RELEASED )
			->setParameter('job_status', Job::STATUS_RELEASED );

		return $query->getResult();
	}
	
	
	/**
	 * find accepted jobs for a user by a given date interval 
	 * 
	 * @param User $user
	 * @param \DateTime $startDate
	 * @param \DateTime $endDate
	 * 
	 * @return array
	 */
	public function findByUserAndInterval( User $user, \DateTime $startDate, 
			\DateTime $endDate )
	{
		$em = $this->getEntityManager();
		$query = $em->createQuery(
				'SELECT job
				 FROM RestooMainBundle:Job job
				 JOIN job.package package
				 WHERE job.receiver = :receiver
				 AND package.startDate >= :startDate
				 AND package.endDate <= :endDate 
				 AND job.status = :status
			')
			->setParameter('status', Job::STATUS_ACCEPTED )
			->setParameter('receiver', $user->getId() )
			->setParameter('startDate', $startDate->format('Y-m-d') )
			->setParameter('endDate', $endDate->format('Y-m-d') );
		
		return $query->getResult();
	}
}
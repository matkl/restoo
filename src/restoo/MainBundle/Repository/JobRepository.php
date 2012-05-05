<?php 
namespace restoo\MainBundle\Repository;

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
}
<?php
namespace restoo\MainBundle\Service;
/**
 * 
 * @author jochen
 */
class DateService
{
	/**
	 * see config.yml (restoo.date)
	 * @var array
	 */
	private $dateConfig;

	/**
	 *
	 * @param array $dateConfig date config (see config.yml)
	 */
	public function __construct($dateConfig)
	{
		$this->dateConfig = $dateConfig;
	}

	/**
	 * returns the date of the sunday for a given week number
	 * 
	 * @param int $week number of week
	 * 
	 * @return \DateTime
	 */
	public function getLastDayOfWeek($week)
	{
		$firstDay = $this->getFirstDayOfWeek($week);
		return $firstDay->add(new \DateInterval('P6D'));
	}

	/**
	 * returns the date of the monday for a given week number
	 * 
	 * @param int $week number of week
	 * 
	 * @return \DateTime
	 */
	public function getFirstDayOfWeek($week)
	{
		$time = strtotime(date('Y') . '0104 +' . ($week - 1) . ' weeks');
		$timestamp = strtotime('-' . (date('w', $time) - 1) . ' days', $time);
		$date = new \DateTime();
		return $date->setTimestamp($timestamp);
	}
}

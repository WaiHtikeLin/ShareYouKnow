<?php
/**
 * 
 */
namespace App\Logics;
class DateFormatter
{
	private $time;
	
	public function __construct($time)
	{	
		$this->time=$time;

	}

	public function getFormattedTime()
	{	
		$time=time()-$this->time;

		if($time<60)
			return "Just now.";

		$time/=60;
		if($time<2)
			return "one min ago.";
		if($time<60)
			return floor($time)." mins ago";
		$time/=60;

		if($time<2)
			return "one hour ago";
		if($time<24)
			return floor($time)." hours ago";
		$time/=24;

		if($time<2)
			return "one day ago";
		if($time<7)
			return floor($time)." days ago";
		$time/=7;

		if($time<2)
			return "one week ago";
		if($time<5)
			return floor($time)." weeks ago";
		return "many times ago";
	}
}
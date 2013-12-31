<?php  
	class EventTime {
		protected $year;
		protected $month;
		protected $day;
		protected $startTime;
		protected $endTime;
        
		public function __construct(array $time) {
			$this->year = intval($time['year']);
			$this->month = intval($time['month']);
			$this->day = intval($time['day']);
			$this->startTime = intval($time['startTime']);
			$this->endTime = intval($time['endTime']);
		}//function __construct(array $time);
		
		public function __get($property_name) {
			return isset($this->$property_name) ? $this->$property_name : null;
		}//function __get($property_name);
		
		public function toString() {
			return $this->day.'/'.$this->month.'/'.$this->year.' '.$this->startTime.'-'.$this->endTime;
		}//function toString();
	}//class EventTime;
	
	class LessonTime extends EventTime {
		private $wkDay;
		private $wkRepeat;
		
		public function __construct(array $time) {
			$this->year = array_key_exists('year', $time) ? intval($time['year']) : 0;
			$this->month = array_key_exists('month', $time) ? intval($time['month']) : 0;
			$this->day = array_key_exists('day', $time) ? intval($time['day']) : 0;
			$this->startTime = intval($time['startTime']);
			$this->endTime = intval($time['endTime']);
			$this->wkDay = $time['wkDay'];
			$this->wkRepeat = array(FALSE,FALSE,FALSE,FALSE,FALSE,FALSE,FALSE,FALSE,FALSE,FALSE,FALSE,FALSE,FALSE);
		}//function __construct(array $time);
        
		public function __get($property_name) {
			return isset($this->$property_name) ? $this->$property_name : null;
		}//function __get($property_name);
		
		public function toString() {
			$string = "Starting at ".$this->startTime." Ending at ".$this->endTime." on ".$this->wkDay." with Repeat: </br>";
			foreach ($this->wkRepeat as $wk) {
				if($wk)
					$string .= 'TRUE ';
				else
					$string .= 'FALSE ';
			}
			$string .= '</br>';
			return $string;
		}//function toString();
	}//class LessonTime;
	
	function semInfo($year, $sem) {
		$data = array('2013' => array('1' => 120813
									,'2' => 130114)
					, '2014' => array('1' => 110814
									, '2' => 120115)
					, '2015' => array('1' => 100815
									, '2' => 110116)
					, '2016' => array('1' => 080816
									, '2' => 090117));
		$SemTime = $data[strval($year)][strval($sem)];
		return array('year' => intval($SemTime%100+2000)
				, 'month' => intval(($SemTime/100)%100)
				, 'day' => intval($SemTime/10000));
	}//semInfo($year, $sem);
    
	function month($month) {
		if($month=='jan')
			return 1;
		else if($month=='feb')
			return 2;
		else if($month=='mar')
			return 3;
		else if($month=='apr')
			return 4;
		else if($month=='may')
			return 5;
		else if($month=='jun')
			return 6;
		else if($month=='jul')
			return 7;
		else if($month=='aug')
			return 8;
		else if($month=='sep')
			return 9;
		else if($month=='oct')
			return 10;
		else if($month=='nov')
			return 11;
		else if($month=='dec')
			return 12;
		else
			return 0;
	}//month($month);
    
	function week($day) {
		if($day=='sun')
			return 7;
		else if($day=='mon')
			return 1;
		else if($day=='tue')
			return 2;
		else if($day=='wed')
			return 3;
		else if($day=='thu')
			return 4;
		else if($day=='fri')
			return 5;
		else if($day=='sat')
			return 6;
		else
			return 0;
	}//week($day);
    
	function fewDaysNextOrBefore(array $time, $n) {
		$year = array_key_exists('year', $time) ? intval($time['year']) : 0;
		$month = array_key_exists('month', $time) ? intval($time['month']) : 0;
		$day = array_key_exists('day', $time) ? intval($time['day']) : 0;
		$Date = strtotime($year.'-'.$month.'-'.$day);
		$newDate = explode('/',date('n/j/Y', strtotime($n, $Date)));
		return array('year' => intval($newDate[2])
					,'month' => intval($newDate[0])
					,'day' => intval($newDate[1]));
    }//fewDaysNextOrBefore(array $time, $n);
?>

<?php
	require_once 'network.php';
	require_once 'time.php';
	require_once 'libs/simple_html_dom.php';
	
	class Lesson {
		private $type;
		private $group;
		private $time;
		private $venue;
		private $remark;
		private $wkRepeatValid;
		
		public function __construct(array $lesson) {
			$this->type = array_key_exists('type', $lesson) ? strtoupper($lesson['type']) : '';
			$this->group = array_key_exists('group', $lesson) ? strtoupper($lesson['group']) : '';
			$this->time = array_key_exists('time', $lesson) ? $lesson['time'] : null;
			$this->venue = array_key_exists('venue', $lesson) ? strtoupper($lesson['venue']) : '';
			$this->remark = array_key_exists('remark', $lesson) ? $lesson['remark'] : 'Invalid';
			$this->wkRepeatValid = $this->setWkRepeat();
		}//__construct(array $lesson);
		
		public function __get($property_name) {
			return isset($this->$property_name) ? $this->$property_name : null;
		}//function __get($property_name);
		
		private function setWkRepeat() {
			$re = strtolower($this->remark);
			if($re=='') {
				for($i=0;$i<13;$i++)
					$this->time->setWkRepeatTrueforThisWk($i);
				return TRUE;
			}//if remark is null, repeat every week.
			
			$re1 = preg_replace('/wk/', '', $re);
			$re2 = preg_replace('/\s/', '', $re1);
			$wks = explode(',', $re2);
			$wkTime = explode('-', $wk);
			foreach($wks as $wk) {
				$wkTime = explode('-', $wk);
				if(is_numeric($wk)) {
					$this->time->setWkRepeatTrueforThisWk($wk-1);
				}
				else if(count($wkTime)==2) {
					for($i=$wkTime[0]-1;$i<$wkTime[1];$i++)
						 $this->time->setWkRepeatTrueforThisWk($i);
				}
				else{
					$this->time->setWkRepeatTrueforThisWk(0);
					return FALSE;
				}
			}
			return TRUE;
		}//function setWkRepeat();

		public function toString(){
			$string = 'Lesson, ';
			$string .= '<b>Type:</b> '.$this->type.' ';
			$string .= '<b>Group:</b> '.$this->group.' ';           
			$string .= '<b>Venue:</b> '.$this->venue.' ';
			$string .= '<b>Remark:</b> '.$this->remark.' ';
			if($this->wkRepeatValid) {
				$string .= '<b>Time:</b> '.$this->time->toString().' ';
			}
			else {
				$string .= '<b>Warning!</b> This lesson\'s wkRepeat info cannot be caught. Only set Wk1.';
			}
			return $string;
		}//function toString();
	}//class Lesson
?>
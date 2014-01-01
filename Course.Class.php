<?php
	require_once 'network.php';
	require_once 'time.php';
	require_once 'libs/simple_html_dom.php';
	
	class Lesson {
		private $course;
		private $type;
		private $group;
		private $time;
		private $venue;
		private $remark;
		private $wkRepeatValid;
		
		public function __construct(array $lesson) {
			$this->course = array_key_exists('course', $lesson) ? $lesson['course'] : null;
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
		
		public function setCourse(Course $course) {
			$this->course = $course;
		}//function setCourse(Course $course);
		
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
			foreach($wks as $wk) {
				$wkTime = explode('-', $wk);
				if(count($wkTime)==2) {
					for($i=$wkTime[0]-1;$i<$wkTime[1];$i++)
						 $this->time->setWkRepeatTrueforThisWk($i);
				}//if remark looks like wk1-3,2-5.
				
				else if(is_numeric($wk)) {
					$this->time->setWkRepeatTrueforThisWk($wk-1);
				}//if remark looks like wk1,2,3
				
				else{
					$this->time->setWkRepeatTrueforThisWk(0);
					return FALSE;
				}//cannot get week repeat information
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
	}//class Lesson;
	
	class Course {
		private $code;
		private $index;
		private $name;
		private $au;
		private $examTime;
		private $lessons;
		private $errorFlag;
		
		private function __construct(array $course) {
			$this->code = $course['code'];
			$this->index = $course['index'];
			$this->name = $course['name'];
			$this->au = $course['au'];
			$this->examTime = $course['examTime'];
			$this->lessons = array();
			foreach($course['lessons'] as $l) {
				$this->addLesson($l);
			}
			$this->errorFlag = 0;
		}//function __construct(array $course);
		
		private function addLesson(Lesson $lesson) {
			array_push($this->lessons, $lesson);
			$lesson->setCourse($this);
		}//addLesson(Lesson $lesson);
		
		public function __get($property_name) {
			return isset($this->$property_name) ? $this->$property_name : null;
		}//function __get($property_name);
		
		public static function getInstanceWithCourseInfo(array $course) {
			if(!array_key_exists('code', $course))
				return null;
			$c = array('code' => $course['code']
				, 'index' => array_key_exists('index', $course) ? $course['index'] : 0
				, 'name' => array_key_exists('name', $course) ? $course['name'] : ''
				, 'au' => array_key_exists('au', $course) ? $course['au'] : 0
				, 'examTime' => array_key_exists('array_key_exists', $course) ? $course['examTime'] : null
				, 'lessons' => array_key_exists('lessons', $course) ? $course['lessons'] : array());
			return new Course($c);
		}//function getInstanceWithCourseInfo(array $course);
		
		public static function getInstanceWithCodeAndIndex($code, $index) {
		}//function getInstanceWithCodeAndIndex($code, $index);
		
		public function toString(){
			$string = 'Course, ';
			$string .= $this->name.' ';
			$string .= 'Code: '.$this->code.' ';
			$string .= 'Index: '.$this->index.' ';
			$string .= 'AU: '.$this->au.' ';
			$string .= $examTime ? $examTime->toString() : 'No exam time ';
			$string .= 'Lessons: </br>';
			foreach($this->lessons as $lesson)
				$string .= $lesson->toString();
			return $string;
		}//function toString();
	}//class Course;
?>
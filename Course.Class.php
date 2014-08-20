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
		private $summary;
		private $description;
		private $wkRepeatValid;
		
		public function __construct(array $lesson) {
			$this->course = array_key_exists('course', $lesson) ? $this->setCourse($lesson['course']) : null;
			$this->type = array_key_exists('type', $lesson) ? strtoupper($lesson['type']) : '';
			$this->group = array_key_exists('group', $lesson) ? strtoupper($lesson['group']) : '';
			$this->time = array_key_exists('time', $lesson) ? (is_array($lesson['time']) ? new LessonTime($lesson['time']) : $lesson['time']) : null;
			$this->venue = array_key_exists('venue', $lesson) ? strtoupper($lesson['venue']) : '';
			$this->remark = array_key_exists('remark', $lesson) ? $lesson['remark'] : 'Invalid';
			$this->wkRepeatValid = $this->setWkRepeat();
		}//__construct(array $lesson);
		
		public function __get($property_name) {
			return isset($this->$property_name) ? $this->$property_name : null;
		}//function __get($property_name);
		
		public function setCourse(Course $course) {
			$this->course = $course;
			if(!$this->wkRepeatValid)
				$course->addErrorFlag();
			$this->summary = $course->code.' '.$this->type;
			if(!$this->wkRepeatValid)
				$summary .= ' *Warning!';
			$this->description = $course->code.' '.$course->name.' '.$course->au.'\n';
			$this->description .= $this->group!='' ? 'Group: '.$this->group.' ' : '';
			$this->description .= $this->remark!='' ? 'Remark: '.$this->remark.' ' : '';
			$this->description .= $this->wkRepeatValid ? '' : '\nWarning: Course Cal cannot get the repeat information. Please edit by yourself.';
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
			$string .= '<b>Summary:</b> '.$this->summary.' ';
			$string .= '<b>Description:</b> '.$this->description.' ';
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
			$this->code = strtoupper($course['code']);
			$this->index = $course['index'];
			$this->name = ucwords($course['name']);
			$this->au = $course['au'];
			$this->examTime = $course['examTime'];
			$this->lessons = array();
			foreach($course['lessons'] as $l) {
				if(is_array($l))
					$this->addNewLesson($l);
				else
					$this->addLesson($l);
			}
			$this->errorFlag = 0;
		}//function __construct(array $course);
		
		private function addLesson(Lesson $lesson) {
			array_push($this->lessons, $lesson);
			$lesson->setCourse($this);
		}//function addLesson(Lesson $lesson);
		
		private function addNewLesson(array $lesson) {
			$l = new Lesson($lesson);
			if($l) {
				array_push($this->lessons, $l);
				$l->setCourse($this);
			}
		}//function addLesson(array $lesson);
		
		public function __get($property_name) {
			return isset($this->$property_name) ? $this->$property_name : null;
		}//function __get($property_name);
		
		public function addErrorFlag() {
			$this->errorFlag++;
		}//function addErrorFlag();
		
		public static function getInstanceWithCourseInfo(array $course) {
			if(!array_key_exists('code', $course))
				return null;
			$c = array('code' => $course['code']
				, 'index' => array_key_exists('index', $course) ? $course['index'] : 0
				, 'name' => array_key_exists('name', $course) ? $course['name'] : ''
				, 'au' => array_key_exists('au', $course) ? $course['au'] : '0 au'
				, 'examTime' => array_key_exists('examTime', $course) ? (is_array($course['examTime']) ? new EventTime($course['examTime']) : $course['examTime']) : null
				, 'lessons' => array_key_exists('lessons', $course) ? $course['lessons'] : array());
			return new Course($c);
		}//function getInstanceWithCourseInfo(array $course);
		
		public static function getInstanceAuto(array $course) {
			if(!array_key_exists('code', $course) || !array_key_exists('index', $course) || !array_key_exists('year', $course) || !array_key_exists('sem', $course))
				return null;
			$code = $course['code'];
			$code = strtoupper($code);
			$index = $course['index'];
			$examTime = array_key_exists('examTime', $course) ? $course['examTime'] : null;
			$info = array('year' => $course['year']
						, 'sem' => $course['sem']);
			if(!array_key_exists('year', $info) || !array_key_exists('sem', $info))
				return null;
			
			$html = str_get_html(fetch(courseURL($code, $info)));
			if(!$html)
				return null;
			$table = $html->find('table');
			if(!$table)
				return null;
			
			//get course information
			$tr = str_get_html($table[0])->find('tr');
			$InfoBlock = str_get_html($tr[0]);
			$nameAndAuBlock = $InfoBlock->find('b');
			$courseName = $nameAndAuBlock[1]->plaintext;
			$courseAU = $nameAndAuBlock[2]->plaintext;
			
			//get index block
			$indexBlock = null;
			$line = -1;
			$trBlocks = str_get_html($table[1])->find('tr');
			for($i=0;$i<count($trBlocks);$i++) {
				$cols = str_get_html ($trBlocks[$i])->find('b');
				for($j=0;$j<count($cols);$j++)
					if($index==$cols[0]->plaintext) {
						$indexBlock = $trBlocks[$i];
						$line = $i;
						break;
					}
				if($line!=-1)
					break;
			}
			if($line==-1)
				return null;
			
			//create a course instance
			$c = array('code' => $code
					, 'index' => $index
					, 'name' => $courseName
					, 'au' => $courseAU
					, 'examTime' => $examTime
					, 'lessons' => array());
			$trs = array();
			array_push($trs, $trBlocks[$line]);
			$line++;
			while(TRUE) {
				if($line>=count($trBlocks))
					break;
				$cols = str_get_html($trBlocks[$line])->find('b');
				$first = $cols[0]->plaintext;
				if($first!='')
					break;
				array_push($trs, $trBlocks[$line]);
				$line++;
			}
			foreach ($trs as $value) {
				$lessonInfo = str_get_html($value)->find('b');
				if(!$lessonInfo)
					return null;
				$times = explode('-',$lessonInfo[4]->plaintext);
				if(!$times)
					return null;
				$lesson = new Lesson(array('type' => $lessonInfo[1]->plaintext
										, 'group' => $lessonInfo[2]->plaintext
										, 'time' => new LessonTime(array('wkDay' => $lessonInfo[3]->plaintext
																	, 'startTime' => intval($times[0])
																	, 'endTime' => intval($times[1])))
										, 'venue' => $lessonInfo[5]->plaintext
										, 'remark' => $lessonInfo[6]->plaintext));
				array_push($c['lessons'], $lesson);
			}
			return Course::getInstanceWithCourseInfo($c);
		}//function getInstanceWithCodeIndexAndInfo($code, $index, array $info);
		
		public function toString(){
			$string = 'Course, ';
			$string .= $this->name.' ';
			$string .= 'Code: '.$this->code.' ';
			$string .= 'Index: '.$this->index.' ';
			$string .= 'AU: '.$this->au.' ';
			$string .= $this->examTime ? $this->examTime->toString() : 'No exam time ';
			$string .= 'Lessons: </br>';
			foreach($this->lessons as $lesson)
				$string .= $lesson->toString();
			return $string;
		}//function toString();
	}//class Course;
?>
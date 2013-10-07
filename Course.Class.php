<?php

    require_once 'network.php';
    require_once 'time.php';
    require_once 'libs/simple_html_dom.php';
    /*
     * Define Lesson and Course Class.
     */
    class Time{
        protected $startTime;
        protected $endTime;
        
        public function getStartTime(){
            return $this->startTime;
        }
        
        public function getEndTime(){
            return $this->endTime;
        }
    }
    
    class ExamTime extends Time{
        private $year;
        private $month;
        private $day;
        
        public function __construct($year, $month, $day, $startTime, $endTime) {
            $this->year = $year;
            $this->month = $month;
            $this->day = $day;
            $this->startTime = $startTime;
            $this->endTime = $endTime;
        }
        
        public function getYear(){
            return $this->year;
        }
        
        public function getMonth(){
            return $this->month;
        }
        
        public function getDay(){
            return $this->day;
        }
        
        public function toString(){
            return "Exam at ".$this->getDay()."/".$this->getMonth()."/".$this->getYear()." Starting at ".$this->getStartTime()." Ending at ".$this->getEndTime();
        }
    }
    
    class LessonTime extends Time{
        private $day;
        private $weekRepeat;
        
        public function __construct($day, $weekRepeat, $startTime, $endTime){
            $this->day = $day;
            $this->weekRepeat = $weekRepeat;
            $this->startTime = $startTime;
            $this->endTime = $endTime;
        }
        
        public function getDay(){
            return $this->day;
        }
        
        public function getWeekRepeat(){
            return $this->weekRepeat;
        }
        
        public function toString(){
           return "Starting at ".$this->getStartTime()." Ending at 
                        ".$this->getEndTime()." on Weekday ".$this->getDay()." with Repeat ".$this->getWeekRepeat();
        }
    }
    
    class Lesson{
        private $type;
        private $group;
        private $time;
        private $venue;
        private $remark;
        
        public function __construct($type, $group, LessonTime $time, $venue, $remark) {
            $this->type = $type;
            $this->group = $group;
            $this->time = $time;
            $this->venue = $venue;
            $this->remark = $remark;
        }
        
        public function getType(){
            return $this->type;
        }
        
        public function getGroup(){
            return $this->group;
        }
        
        public function getTime(){
            return $this->time;
        }
        
        public function getVenue(){
            return $this->venue;
        }
        
        public function getRemark(){
            return $this->remark;
        }

        public function toString(){
            $var = "Lesson, ";
            $var .= "Type: ".$this->getType()." ";
            $var .= "Group: ".$this->getGroup()." ";
            $var .= "Time: ".$this->getTime()->toString()." ";
            $var .= "Venue: ".$this->getVenue()." ";
            $var .= "Remark: ".$this->getRemark();
            return $var;
        }
    }
    
    class Course{
        private $code;
        private $index;
        private $name;
        private $au;
        private $examTime;
        private $lessons;
        
        public function __construct($code, $index) {
            $this->code = $code;
            $this->index = $index;
            $this->lessons = array();
        }
        
        public function getCode(){
            return $this->code;
        }

        public function getIndex(){
            return $this->index;
        }
        
        public function setName($name){
            $this->name = $name;
        }
        
        public function getName(){
            return $this->name;
        }
        
        public function setAU($au){
            $this->au = $au;
        }
        
        public function getAU(){
            return $this->au;
        }

        public function setExamTime(ExamTime $examTime){
            $this->examTime = $examTime;
        }
        
        public function getExamTime(){
            return $this->examTime;
        }
                
        public function addLesson(Lesson $lesson){
            array_push($this->lessons, $lesson);
        }
        
        public function getLessons(){
            return $this->lessons;
        }
        
        public function toString(){
            $var = "Course, ";
            $var .= "Code: ".$this->getCode()." ";
            $var .= "Index: ".$this->getIndex()." ";
            $var .= "Name: ".$this->getName()." ";
	    $var .= "AU: ".$this->getAU()." ";
            //$var .= "ExamTime: ".$this->getExamTime()->toString()." </br>";
            $var .= "Lessons: </br>";
            $count = count($this->getLessons());
            for($i=0;$i<$count;$i++){
                $var .= $this->lessons[$i]->toString()."</br>";
            }
            return $var;
        }
    }
    
    function analyse($code, $index){
        //Get Course Data from Course Page;
        $htmlAllData = fetch(courseURL($code));
        $html = str_get_html($htmlAllData);
        $table = $html->find('table');
        
        //Get Course Information
        $InfoBlock = str_get_html(str_get_html($table[0])->find('tr')[0]);
        $courseName = $InfoBlock->find('b')[1];
        $courseAU = $InfoBlock->find('b')[2];

        //Get Index Block
        $indexBlock = null;
	$line = -1;
	$trBlocks = str_get_html($table[1])->find('tr');
        for($i=0;$i<count($trBlocks);$i++){
	    $cols = str_get_html ($trBlocks[$i])->find('b');
	    for($j=0;$j<count($cols);$j++)
		if($index==$cols[0]->plaintext){
		    $indexBlock = $trBlocks[$i];
		    $line = $i;
		    break;
		}
            if($line!=-1)
                break;
        }
        if($line==-1)
            return null;
        
        $course = new Course($code, $index);
	$course->setName($courseName->plaintext);
	$course->setAU($courseAU->plaintext);
        $trs = array();
        array_push($trs, $trBlocks[$line]);
        $line++;
        while($line<count($trBlocks) && str_get_html($trBlocks[$line])->find('b')[0]->plaintext==""){
            array_push($trs, $trBlocks[$line]);
            $line++;
        }
        foreach ($trs as $value) {
            $lessonInfo = str_get_html($value)->find('b');
            $times = explode('-',$lessonInfo[4]->plaintext);
            $lessonTime = new LessonTime(week($lessonInfo[3]->plaintext), 0, intval($times[0]), intval($times[1]));
            $lesson = new Lesson($lessonInfo[1]->plaintext, $lessonInfo[2]->plaintext, $lessonTime, $lessonInfo[5]->plaintext, $lessonInfo[6]->plaintext);
            $course->addLesson($lesson);
        }
        
        return $course;
    }
?>
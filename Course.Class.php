<?php
    require_once 'network.php';
    require_once 'time.php';
    require_once 'libs/simple_html_dom.php';
    /*
     * Define Lesson and Course Class.
     */   
    class ExamTime extends EventTime{              
        public function __construct($year, $month, $day, $startTime, $endTime) {
            $this->year = $year;
            $this->month = $month;
            $this->day = $day;
            $this->startTime = $startTime;
            $this->endTime = $endTime;
        }
        
        public function toString(){
            return "Exam at ".$this->day."/".$this->month."/".$this->year." Starting at ".$this->startTime." Ending at ".$this->endTime;
        }
    }
    
    class LessonTime extends EventTime{
        private $wkday;
        private $weekRepeat;
        
        public function __construct($day, $weekRepeat, $startTime, $endTime){
            $this->wkday = $day;
            $this->weekRepeat = $weekRepeat;
            $this->startTime = $startTime;
            $this->endTime = $endTime;
        }
        
        public function getWkDay(){
            return $this->wkday;
        }
        
        public function getWeekRepeat(){
            return $this->weekRepeat;
        }
        
        public function toString(){
           return "Starting at ".$this->startTime." Ending at 
                        ".$this->endTime." on Weekday ".$this->wkday." with Repeat ".$this->weekRepeat;
        }
    }
    
    class Lesson{
        private $type;
        private $group;
        private $time;
        private $venue;
        private $remark;
        
        public function __construct($type, $group, LessonTime $time, $venue, $remark) {
            $this->type = strtoupper($type);
            $this->group = strtoupper($group);
            $this->time = $time;
            $this->venue = strtoupper($venue);
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
            $this->examTime = null;
        }
        
        public function getCode(){
            return $this->code;
        }

        public function getIndex(){
            return $this->index;
        }
        
        public function setName($name){
            $this->name = ucwords($name);
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
            if($this->getExamTime()!=null)
                $var .= "ExamTime: ".$this->getExamTime()->toString()." </br>";
            $var .= "Lessons: </br>";
            $count = count($this->getLessons());
            for($i=0;$i<$count;$i++){
                $var .= $this->lessons[$i]->toString()."</br>";
            }
            return $var;
        }
    }
    
    function analyseCoursePage($code, $index){
        $code = strtoupper($code);
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
    
    function analysePrintablePage($url){
        $html = str_get_html(fetch($url));
        $courses = array();
        $table = str_get_html(str_get_html($html->find('table')[0])->find('table')[2]);
        $trBlocks = $table->find('tr');
        $numbersOfBlocks = count($trBlocks);
        for($i=1;$i<$numbersOfBlocks-1;$i++){
            $tds = str_get_html($trBlocks[$i])->find('td');
            $index = intval($tds[0]->plaintext);
            $code = $tds[1]->plaintext;
            $course = analyseCoursePage($code, $index);
            if($course!=null){
                if(preg_replace('/\s/', '', $tds[4]->plaintext)=='-')
                    array_push($courses, $course);
                else{
                    $examSchedule = explode(' ', $tds[4]->plaintext);
                    $first = explode('-', $examSchedule[0]);
                    $second = explode('-', $examSchedule[1]);
                    $examTime = new ExamTime(2000+intval($first[2]), month($first[1]), intval($first[0]), intval($second[0]), intval($second[1]));
                    $course->setExamTime($examTime);
                    array_push($courses, $course);
                }
            }
        }
        return $courses;
    }
?>
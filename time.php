<?php

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
    
    function month($month){
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
    }
    
    function week($day){
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
    }
?>

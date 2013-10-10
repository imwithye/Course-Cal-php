<?php  
    class Time{
        protected $year;
        protected $month;
        protected $day;
        
        public function __construct($year, $month, $day) {
            $this->year = $year;
            $this->month = $month;
            $this->day = $day;
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
            return $this->day.'/'.$this->month.'/'.$this->year;
        }
    }
    
    class EventTime extends Time{
        protected $startTime;
        protected $endTime;
        
        public function getStartTime(){
            return $this->startTime;
        }
        
        public function getEndTime(){
            return $this->endTime;
        }
    }
    
    function semInfo($year, $sem){
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
    
    function fewDaysNextOrBefore($time, $n){
        $year = $time['year'];
        $month = $time['month'];
        $day = $time['day'];
        $Date = strtotime($year.'-'.$month.'-'.$day);
        $newDate = explode('/',date('n/j/Y', strtotime($n, $Date)));
        return array('year' => intval($newDate[2])
                    ,'month' => intval($newDate[0])
                    ,'day' => intval($newDate[1]));
    }
?>

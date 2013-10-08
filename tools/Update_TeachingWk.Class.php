<?php
    require_once '../network.php';
    require_once '../time.php';
    require_once '../libs/simple_html_dom.php';
    
    class TeachingWkTime{
        private $start;
        private $end;
        
        public function __constrator(){
            $this->start = null;
            $this->end = null;
        }
        
        public function getStart(){
            return $this->start;
        }
        
        public function getEnd(){
            return $this->end;
        }
        
        public function setTime($timeString1, $timeString2){
            $t1 = explode('-', $timeString1);
            $this->start = new Time(2000+intval($t1[2]), month($t1[1]), intval($t1[0]));
            $t2 = explode('-', $timeString2);
            $this->end = new Time(2000+intval($t2[2]), month($t2[1]), intval($t2[0]));
        }

        public function toString(){
            return 'From: '.$this->start->toString()." to ".$this->end->toString();
        }
    }
    
    Class TeachingWk{
        private $firstPart;
        private $recessWk;
        private $secondPart;
        
        public function __constrator(){
            $this->firstPart = new TeachingWkTime;
            $this->recessWk = new TeachingWkTime;
            $this->secondPart = new TeachingWkTime;
        }
        
        public function setTime(TeachingWkTime $firstPart, TeachingWkTime $recessWk, TeachingWkTime $secondPart){
            $this->firstPart = $firstPart;
            $this->recessWk = $recessWk;
            $this->secondPart = $secondPart;
        }
        
        public function getFirst(){
            return $this->firstPart;
        }
        
        public function getRecess(){
            return $this->recessWk;
        }
        
        public function getSecond(){
            return $this->secondPart;
        }
        
        public function toString(){
            $var = '';
            $var .= 'First Teaching Wk '.$this->firstPart->toString().'.</br>';
            $var .= 'Recess Wk '.$this->recessWk->toString().'.</br>';
            $var .= 'Second Teaching Wk '.$this->secondPart->toString().'.</br>';
            return $var;
        }
    }
    
    function analyseTimetablePage($sem){
        $table = str_get_html(fetch(timetableURL()))->find('table')[0];
        $trBlocks = str_get_html($table)->find('tr');
        if($sem==1){
            $i = 3;
            $j = 4;
            $k = 5;
        }
        else if($sem==2){
            $i = 8;
            $j = 9;
            $k = 10;
        }
        else
            return null;
        $firstTimeBlock = str_get_html($trBlocks[$i])->find('td');
        $recessTimeBlock = str_get_html($trBlocks[$j])->find('td');
        $secondTimeBlock = str_get_html($trBlocks[$k])->find('td');
            
        $firstTeachingTime = new TeachingWkTime();
        $firstTeachingTime->setTime(preg_replace('/\s/', '', $firstTimeBlock[1]->plaintext),preg_replace('/\s/', '', $firstTimeBlock[2]->plaintext));
        $recessTime = new TeachingWkTime();
        $recessTime->setTime(preg_replace('/\s/', '', $recessTimeBlock[1]->plaintext),preg_replace('/\s/', '', $recessTimeBlock[2]->plaintext));
        $secondTeachingTime = new TeachingWkTime();
        $secondTeachingTime->setTime(preg_replace('/\s/', '', $secondTimeBlock[1]->plaintext),preg_replace('/\s/', '', $secondTimeBlock[2]->plaintext));
        $teachingWk = new TeachingWk();
        $teachingWk->setTime($firstTeachingTime, $recessTime, $secondTeachingTime);
        
        return $teachingWk;
    }
?>

<?php
    require_once 'libs/iCalcreator.class.php';
    require_once 'network.php';
    require_once 'Course.Class.php';
    
    function semInfo(){
        return array('2013' => array('1' => 120813
                                        ,'2' => 130114)
                    , '2014' => array('1' => 110814
                                    , '2' => 120115)
                    , '2015' => array('1' => 100815
                                    , '2' => 110116)
                    , '2016' => array('1' => 080816
                                    , '2' => 090117));
    }
    
    function setCourseEvent($course, $event, $SemTime){
        $startTime = array('year' => $SemTime%100+2000
                        , 'month' => ($SemTime/100)%100
                        , 'day' => $SemTime%10000);
        //TO DO;
        return $startTime;  //This is for testing.
    }
    
    function createCal($url){
        $tz = 'Asia/Singapore';//define the time zone
        $info = getUserInfo($url);
        if($info==null)
            return null;
        $SemInfo = semInfo();
        $courses = analysePrintablePage($url, $info);
        if(count($courses)==0)
            return null;
        $config = array('unique_id' => $info['p1']
                    , 'TZID' => $tz);
        $v = new vcalendar($config);
        foreach($courses as $course){
            $event = & $v->newComponent('vevent');
            setCourseEvent($course, $event, $SemInfo[$info['year']['sem']]);
        }
        return $v;
    }
   
?>

<?php
    require_once 'libs/iCalcreator.class.php';
    require_once 'network.php';
    require_once 'Course.Class.php';
    
    function setCourseEvent($course, $event, $SemInfo){
        //TO Do;
    }
    
    function createCal($url){
        $tz = 'Asia/Singapore';//define the time zone
        $info = getUserInfo($url);
        if($info==null)
            return null;
        $SemInfo = array();
        $courses = analysePrintablePage($url, $info);
        if(count($courses)==0)
            return null;
        $config = array('unique_id' => $info['p1']
                    , 'TZID' => $tz);
        $v = new vcalendar($config);
        foreach($courses as $course){
            $event = & $v->newComponent('vevent');
            setCourseEvent($course, $event, $SemInfo);
        }
        return $v;
    }
   
?>

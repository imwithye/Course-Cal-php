<?php
    require_once 'libs/iCalcreator.class.php';
    require_once 'network.php';
    require_once 'Course.Class.php';
    
    function setCourseEvent(Course $course, vcalendar $ical, $info){
        $startTime = semInfo($info['year'], $info['sem']);
        return $startTime;  //This is for testing.
    }
    
    function createCal($url){
        $tz = 'Asia/Singapore';//define the time zone
        $info = getUserInfo($url);
        if($info==null)
            return null;
        $courses = analysePrintablePage($url, $info);
        if(count($courses)==0)
            return null;
        $config = array('unique_id' => $info['p1']
                    , 'TZID' => $tz
                    , 'filename' => $info['p1']);
        $ical = new vcalendar($config);
        foreach($courses as $course){
            setCourseEvent($course, $ical, $info);
        }
        return $ical;
    }
?>

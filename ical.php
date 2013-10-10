<?php
    require_once 'libs/iCalcreator.class.php';
    require_once 'network.php';
    require_once 'Course.Class.php';
    
    function setCourseEvent(Course $course, vcalendar $ical, $info){
        $startTime = semInfo($info['year'], $info['sem']);
        $lessons = (Array)$course->getLessons();
        foreach ($lessons as $lesson) {
            if(!$lesson->getWkRepeatValid()){
                $course->setErrorFlag();   //an Error found for this course;
            }     
            $lessonEvent = & $ical->newComponent('vevent');
            //set summary(name)
            $summary = $course->getCode().' ';
            $summary .= $lesson->getType();
            $lessonEvent->setProperty( "summary", $summary );
            //set start and end time. 
            $start = fewDaysNextOrBefore($startTime, '+'.($lesson->getTime()->getWkDay()-1).' days');
            $start['hour'] = intval($lesson->getTime()->getStartTime())/100;
            $start['min'] = intval($lesson->getTime()->getStartTime())%100;
            $start['sec'] = 0;
            $lessonEvent->setProperty( "dtstart", $start );
            $end = fewDaysNextOrBefore($startTime, '+'.($lesson->getTime()->getWkDay()-1).' days');
            $end['hour'] = intval($lesson->getTime()->getEndTime())/100;
            $end['min'] = intval($lesson->getTime()->getEndTime())%100;
            $end['sec'] = 0;
            $lessonEvent->setProperty( "dtend", $end );          
            //set location
            $lessonEvent->setProperty( "LOCATION", $lesson->getVenue());
            //set description
            $description = $course->getCode().', ';
            $description .= $course->getName().', ';
            $description .= $course->getAU().'\n';
            if($lesson->getGroup()!=null)
                $description .= 'Group: '.$lesson->getGroup().', ';
            if($lesson->getRemark()!=null)
                $description .= 'Remark: '.$lesson->getRemark();
            $lessonEvent->setProperty( "description", $description);
            //set week repeat
            if(!$lesson->getWkRepeatValid())
                continue;
            $endTime = fewDaysNextOrBefore($startTime, '+14 weeks');
            $rule = array('FREQ' => 'WEEKLY'
                    , 'UNTIL' => $endTime['year'].'/'.$endTime['month'].'/'.$endTime['day']);
            $lessonEvent->setProperty("rrule", $rule);
        }
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

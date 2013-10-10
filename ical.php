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
            $shour = intval($lesson->getTime()->getStartTime())/100;
            $smin = intval($lesson->getTime()->getStartTime())%100;
            $start['hour'] = $shour;
            $start['min'] = $smin;
            $start['sec'] = 0;
            $lessonEvent->setProperty( "dtstart", $start );
            $end = fewDaysNextOrBefore($startTime, '+'.($lesson->getTime()->getWkDay()-1).' days');
            $ehour = intval($lesson->getTime()->getEndTime())/100;
            $emin = intval($lesson->getTime()->getEndTime())%100;
            $end['hour'] = $ehour;
            $end['min'] = $emin;
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
            $exdate = array('year' => $start['year']
                        , 'month' => $start['month']
                        , 'day' => $start['day']);
            $recess = fewDaysNextOrBefore($exdate, '+7 weeks');
            $recess['hour'] = $shour;
            $recess['min'] = $smin;
            $recess['sec'] = 0;
            $wk = $lesson->getTime()->getWeekRepeat();
            $exdates = array();
            array_push($exdates, $recess);
            for($i=0;$i<13;$i++){
                if($i<7)
                    $j = $i;
                else
                    $j = $i+1;
                if(!$wk[$i]){
                    $w = fewDaysNextOrBefore($exdate, '+'.$j.' weeks');
                    $w['hour'] = $shour;
                    $w['min'] = $smin;
                    $w['sec'] = 0;
                    array_push($exdates, $w);
                }
            }
            $lessonEvent->setProperty("exdate", $exdates, array('TZID'=>$info['tz'])); //skip recess;
        }
    }
    
    function createCal($url){
        $info = getUserInfo($url);
        if($info==null)
            return null;
        $courses = analysePrintablePage($url, $info);
        if(count($courses)==0)
            return null;
        $config = array('unique_id' => $info['p1']
                    , 'TZID' => $info['tz']
                    , 'filename' => 'Course-'.$info['p1']);
        $ical = new vcalendar($config);
        foreach($courses as $course){
            setCourseEvent($course, $ical, $info);
        }
        return $ical;
    }
?>

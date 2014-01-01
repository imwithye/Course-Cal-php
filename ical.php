<?php
    require_once 'libs/iCalcreator.class.php';
    require_once 'network.php';
    require_once 'Course.Class.php';
    
    function setCourseEvent(Course $course, vcalendar $ical, $info){
        $startTime = semInfo($info['year'], $info['sem']);
        $lessons = (Array)$course->getLessons();
        //add lessons
        foreach ($lessons as $lesson) {
            if(!$lesson->getWkRepeatValid()){
                $course->setErrorFlag();   //an Error found for this course;
            }     
            $lessonEvent = & $ical->newComponent('vevent');
            //set summary(name)
            $summary = $course->getCode().' ';
            $summary .= $lesson->getType();
            if(!$lesson->getWkRepeatValid())
                $summary .= ' *Warning!';
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
                $description .= 'Group: '.$lesson->getGroup();
            if($lesson->getRemark()!=null)
                $description .= ', Remark: '.$lesson->getRemark();
            if(!$lesson->getWkRepeatValid())
                $description .= '\nWarning: Course Cal cannot get the Repeat Information, pls edit by yourself.';
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
            $lessonEvent->setProperty("exdate", $exdates, array('TZID'=>$info['tz']));
        }
        
        //add examtime
        $examtime = $course->getExamTime();
        if($examtime==null)
            return;
        $start = array('year' => $examtime->getYear()
                    , 'month' => $examtime->getMonth()
                    , 'day' => $examtime->getDay()
                    , 'hour' => intval($examtime->getStartTime())/100
                    , 'min' => intval($examtime->getStartTime())%100
                    , 'sec' => 0);
        $end = array('year' => $examtime->getYear()
                    , 'month' => $examtime->getMonth()
                    , 'day' => $examtime->getDay()
                    , 'hour' => intval($examtime->getEndTime())/100
                    , 'min' => intval($examtime->getEndTime())%100
                    , 'sec' => 0);
        $exam = & $ical->newComponent('vevent');
        $exam->setProperty( "dtstart", $start );
        $exam->setProperty( "dtend", $end );
        $exam->setProperty( "summary", $course->getCode().' EXAM!' );
        $exam->setProperty( "description", $course->getCode().', '.$course->getName().', '.$course->getAU());
        return;
    }
    
	function createCal($url){
		$info = getUserInfo($info);
		$courses = Course::getArrayWithPrintablePage($url);
		if(!courses)
			return null;
		$config = array('unique_id' => $info['p1']
				, 'TZID' => $info['tz']
				, 'filename' => 'AY'.$info['year'].'-'.($info['year']+1).'-Sem-'.$info['sem']);
		$ical = new vcalendar($config);
		$error = FALSE;
		foreach($courses as $course){
			if($course->errorFlag>0)
				$error = TRUE;
			setCourseEvent($course, $ical, $info);
		}
		return array('ics'=>$ical
				, 'url'=>$url,
				, 'error' => $error);
	}
?>

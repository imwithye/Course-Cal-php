<?php
	require_once '../ical.php';
    
    $url = 'https://wish.wis.ntu.edu.sg/pls/webexe/AUS_STARS_PLANNER.planner?p1=NTU_U1220539K&p2=17D7C90E1CB1C884&student_type=F&acad=2013&semester=2&subj_code=BU8201&subj_code=CZ2006&subj_code=CZ2007&subj_code=CZ3005&subj_code=HC2003&subj_code=HW0210&subj_code=&subj_code=&subj_code=&subj_code=&subj_code=&subj_code=&subj_code=&index_nmbr=00182&index_nmbr=10433&index_nmbr=10282&index_nmbr=10315&index_nmbr=17205&index_nmbr=10376&index_nmbr=&index_nmbr=&index_nmbr=&index_nmbr=&index_nmbr=&index_nmbr=&index_nmbr=&subj_type=P&subj_type=C&subj_type=C&subj_type=C&subj_type=X&subj_type=C&subj_type=&subj_type=&subj_type=&subj_type=&subj_type=&subj_type=&subj_type=&class_info=&plan_no=&plan1_exists=Y&plan2_exists=N&plan3_exists=N&boption=Preview';
    
    $v = createCal($url);
    if($v==null)
        echo 'Error';
    else
        $v['ics']->returnCalendar();
?>

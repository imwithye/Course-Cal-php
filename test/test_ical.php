<?php
    include_once '../ical.php';
    
    $url = "https://wish.wis.ntu.edu.sg/pls/webexe/AUS_STARS_PLANNER.planner?p1=NTU_U1220539K&p2=17D7C90E1CB1C884&student_type=F&acad=2013&semester=1&subj_code=CZ2001&subj_code=CZ2002&subj_code=CZ2003&subj_code=CZ2004&subj_code=CZ2005&subj_code=MH8300&subj_code=HW0001&subj_code=HC2011&subj_code=&subj_code=&subj_code=&subj_code=&subj_code=&index_nmbr=10227&index_nmbr=10235&index_nmbr=10463&index_nmbr=10254&index_nmbr=10262&index_nmbr=72403&index_nmbr=20202&index_nmbr=17212&index_nmbr=&index_nmbr=&index_nmbr=&index_nmbr=&index_nmbr=&subj_type=C&subj_type=C&subj_type=C&subj_type=C&subj_type=C&subj_type=P&subj_type=%20&subj_type=G&subj_type=&subj_type=&subj_type=&subj_type=&subj_type=&class_info=&plan_no=&plan1_exists=Y&plan2_exists=Y&plan3_exists=N&boption=Preview";
    $v = createCal($url);
    if($v==null)
        echo 'Error';
    else
        $v->returnCalendar();
?>

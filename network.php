<?php
    /*
     * author Ciel
     */
     
     /* ---------------------------URL FUNCTIONS--------------------------*/
    function courseURL($code){
        $y = date("Y");
        $m = date("m");
        $sem = 0;
        if($m<5){
            $y -= 1;
            $sem = 2;
        }else if($m>=11){
            $sem = 2;
        }else{
            $sem = 1;
        }
        $url = "http://wish.wis.ntu.edu.sg/webexe/owa/AUS_SCHEDULE.";
        $url .= "main_display1?staff_access=false&acadsem=".$y.";".$sem;
        $url .= "&r_subj_code=".strtoupper($code)."&boption=Search&r_search_type=F";
        return $url;
    }
    
    function timetableURL(){
        $y = date("Y");
        $m = date("m");
        if($m<=5)
            $y = $y-1;
        $url = "http://www.ntu.edu.sg/Students/Undergraduate/AcademicServices/AcademicCalendar/Pages/";
        $url .= $y."-".($y%100+1).".aspx";
        return $url;
    }
    /* -----------------------END URL FUNCTIONS--------------------------*/

    function fetch($url){
        $url = preg_replace('/https/','http',$url);
        return preg_replace("/\n/","",strtolower(file_get_contents($url)));
    }
?>

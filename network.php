<?php
     /* ---------------------------URL FUNCTIONS--------------------------*/
    function courseURL($code, array $info){
        $y = $info['year'];
        $sem = $info['sem'];
        $url = "http://wish.wis.ntu.edu.sg/webexe/owa/AUS_SCHEDULE.";
        $url .= "main_display1?staff_access=false&acadsem=".$y.";".$sem;
        $url .= "&r_subj_code=".strtoupper($code)."&boption=Search&r_search_type=F";
        return $url;
    }
    
    /* -----------------------END URL FUNCTIONS--------------------------*/

    function getUserInfo($url){
        $matches = array();
        preg_match('/(?<=\?p1=NTU_)\w+(?=&)/', $url, $matches);
        if(count($matches)!=1)
            return null;
        $p1 = $matches[0];
        preg_match('/(?<=&p2=)\w+(?=&)/', $url, $matches);
        if(count($matches)!=1)
            return null;
        $p2 = $matches[0];
        preg_match('/(?<=&acad=)\d+(?=&)/', $url, $matches);
        if(count($matches)!=1)
            return null;
        $year = $matches[0];
        preg_match('/(?<=&semester=)\d(?=&)/', $url, $matches);
        if(count($matches)!=1)
            return null;
        $sem = $matches[0];
        $info = array('p1' => $p1
                    , 'p2' => $p2
                    , 'year' => $year
                    , 'sem' => $sem);
        return $info;
    }
    
    function fetch($url){
        $url = preg_replace('/https/','http',$url);
        return preg_replace("/\n/","",strtolower(file_get_contents($url)));
    }
?>

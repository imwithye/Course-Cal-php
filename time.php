<?php
    function week($day){
        if($day=='sun')
            return 7;
        else if($day=='mon')
            return 1;
        else if($day=='tue')
            return 2;
        else if($day=='wed')
            return 3;
        else if($day=='thu')
            return 4;
        else if($day=='fri')
            return 5;
        else if($day=='sat')
            return 6;
        else
            return 0;
    }
?>

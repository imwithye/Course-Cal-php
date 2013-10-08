<?php

    function month($month){
        if($month=='jan')
            return 1;
        else if($month=='feb')
            return 2;
        else if($month=='mar')
            return 3;
        else if($month=='apr')
            return 4;
        else if($month=='may')
            return 5;
        else if($month=='jun')
            return 6;
        else if($month=='jul')
            return 7;
        else if($month=='aug')
            return 8;
        else if($month=='sep')
            return 9;
        else if($month=='oct')
            return 10;
        else if($month=='nov')
            return 11;
        else if($month=='dec')
            return 12;
        else
            return 0;
    }
    
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

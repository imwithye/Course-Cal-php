<?php
    include_once '../time.php';
    echo 'Test semInfo</br>';
    $date1 = semInfo(2013, 1);
    echo $date1['day'].'/'.$date1['month'].'/'.$date1['year'];
    echo '</br><hr>';
    
    echo 'Testing fewDaysNextOrBefore.</br>';
    $date2 = fewDaysNextOrBefore(array('year'=>2013, 'month'=>12,'day'=>1), '+1 week');
    echo $date2['day'].'/'.$date2['month'].'/'.$date2['year'];
?>
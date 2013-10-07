<?php
    include_once '../network.php';
    /*
     * Test function fetch(url), using courseURL('CZ2001') and timetableURL().
     */
    $test = courseURL("CZ2001");
    echo fetch($test);
?>

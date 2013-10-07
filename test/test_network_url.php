<?php
    include_once '../network.php';
    echo "<!DOCTYPE html>";
    echo "
        <html>
        <head>
            <title>test_network.php</title>
        </head>
        <body>";
    
    /*
     * Test funtion courseURL(code), using course code CZ2001.
     */
    echo 'Test funtion courseURL(code), using course code CZ2001.</br>';
    echo courseURL("CZ2001");
    echo '<hr>';
    
    /*
     * Test function timetableURL().
     */
    echo 'Test function timetableURL()</br>';
    echo timetableURL();
    echo '<hr>';
    
    echo '</body></html>';
?>

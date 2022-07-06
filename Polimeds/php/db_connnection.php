<?php

    function OpenCon() {

        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "polimeds2022";
        $db = "polimeds";
        $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);
        
        return $conn;
    }
    
    function CloseCon($conn) {
        
        $conn -> close();
    }
    
?>
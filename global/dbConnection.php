<?php
    $serverName = "localhost";
    $username = "root";
    $password = "";
    $dbName =  "rideshare";
    
    $connection = mysqli_connect($serverName, $username, $password, $dbName);

    if (!$connection){
        die("No connection: " . mysqli_connect_error()); 
    }
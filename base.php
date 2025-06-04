<?php
    $server = "localhost";
    $user = "root";
    $password = "root";
    $db = "mini_registration";

    $connection = mysqli_connect($server, $user, $password, $db);
    
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
?>
<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sciospoc";

    $conn = new mysqli("$servername", "$username", "$password", "$dbname");

    if(!$conn){
        die(mysqli_error($conn));
    }

?>
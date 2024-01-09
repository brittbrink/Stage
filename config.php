<?php 
    $servername = "localhost";
    $username = "root";
    $password = "Exclus13f.net";
    $dbname = "sciospoc";

    $conn = new mysqli("$servername", "$username", "$password", "$dbname");

    if(!$conn){
        die(mysqli_error($conn));
    }

?>
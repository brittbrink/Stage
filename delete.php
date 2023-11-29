<?php
    include 'config.php';

    if(isset($_GET['deleteID'])){
        $id=$_GET['deleteID'];

        $sql="delete from `users` where id=$id";
        $result=mysqli_query($conn, $sql);

        if($result){
            // echo "Data deleted succesfully";
            header('location:read.php');
        }
        else{
            die(mysqli_error($conn));
        }
    }

?>
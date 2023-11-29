<?php
    include "config.php";

    if(isset($_POST['submit'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
    

        $sql = "insert into `users` (firstname, lastname, email, password) values ('$firstname', '$lastname', '$email', '$password')";

        $result = mysqli_query($conn, $sql);

        if($result){
            // echo "New record created succesfully";
            header('location:read.php');
        }
        else {
            die(mysqli_query($conn));
        }
    }
    // $conn->close();

 ?>   

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

    <title>PHP CRUD</title>
  </head>
  <body>
    <div class="container my-5">
    <form method="POST">
        <div class="form-group">
            <label> First name: </label>
            <input type="text" class="form-control" 
            placeholder="Enter your first name" 
            name="firstname" autocomplete="off">
        </div>
        <div class="form-group">
            <label> Last name: </label>
            <input type="text" class="form-control" 
            placeholder="Enter your last name" 
            name="lastname" autocomplete="off">
        </div>
        <div class="form-group">
            <label> Email address: </label>
            <input type="email" class="form-control" 
            placeholder="Enter your email" 
            name="email" autocomplete="off">
            <!-- <small id="emailHelp" class="form-text text-muted">We won't share your email with anyone else.</small> -->
        </div>
        <div class="form-group">
            <label> Password: </label>
            <input type="password" class="form-control" 
            placeholder="Password"
            name="password" autocomplete="off">
        </div>
        <!-- <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                <label class="form-check-label" for="invalidCheck">
                    Agree to terms and conditions
                </label>
            </div>
        </div> -->
        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    </form>
    </div>

 </body>
</html>

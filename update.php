<?php
    include "config.php";

    $id=$_GET['updateID'];

    $sql="Select * from `users` where id=$id";
    $result=mysqli_query($conn, $sql);
    $row=mysqli_fetch_assoc($result);
    $firstname=$row['firstname'];
    $lastname=$row['lastname'];
    $email=$row['email'];
    $password=$row['password'];

    if(isset($_POST['submit'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
    

        $sql = "update `users` set id=$id, firstname='$firstname', lastname='$lastname', email='$email', password='$password' where id=$id";
        $result = mysqli_query($conn, $sql);

        if($result){
            // echo "Data updated succesfully";
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
            name="firstname" autocomplete="off" value=<?php echo $firstname; ?>>
        </div>
        <div class="form-group">
            <label> Last name: </label>
            <input type="text" class="form-control" 
            placeholder="Enter your last name" 
            name="lastname" autocomplete="off" value=<?php echo $lastname; ?>>
        </div>
        <div class="form-group">
            <label> Email address: </label>
            <input type="email" class="form-control" 
            placeholder="Enter your email" 
            name="email" autocomplete="off" value=<?php echo $email; ?>>
            <!-- <small id="emailHelp" class="form-text text-muted">We won't share your email with anyone else.</small> -->
        </div>
        <div class="form-group">
            <label> Password: </label>
            <input type="password" class="form-control" 
            placeholder="Password"
            name="password" autocomplete="off" value=<?php echo $password; ?>>
        </div>
        <!-- <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                <label class="form-check-label" for="invalidCheck">
                    Agree to terms and conditions
                </label>
            </div>
        </div> -->
        <button type="submit" class="btn btn-primary" name="submit">Update</button>
    </form>
    </div>

 </body>
</html>

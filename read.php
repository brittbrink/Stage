<?php
    include 'config.php';

    $sql="Select * from `users`";
    $result=mysqli_query($conn, $sql);

    if($result){
        while($row=mysqli_fetch_assoc($result)){
            $id=$row['id'];
            $firstname=$row['firstname'];
            $lastname=$row['lastname'];
            $email=$row['email'];
            $password=$row['password'];
        }
    }
    
?> 



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> PHP CRUD </title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

    </head>
    <body>
        <div class="container">
            <a class="btn btn-primary my-5" href="create.php" role="button"> Add user </a>

            <table class="table">
            <thead class="thead">
                <tr class="table-primary">
                    <th scope="col">Relation number</th>
                    <th scope="col">First name</th>
                    <th scope="col">Last name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Password</th>
                    <th scope="col">Operations</th>
                </tr>
            </thead>
            <tbody>
                
                <tr>
                    <th scope="row"> <?php echo $id; ?> </th>
                    <td> <?php echo $firstname; ?> </td>
                    <td> <?php echo $lastname; ?></td>
                    <td> <?php echo $email; ?></td>
                    <td> <?php echo $password; ?></td>
                    <td>
                        <a class="btn btn-primary" href="update.php?updateID= <?php echo $id ?>" role="button"> Update </a>
                        <a class="btn btn-danger" href="delete.php?deleteID=<?php echo $id ?>" role="button"> Delete </a>
                </td>
                </tr>
            </tbody>
            </table>


        </div>

    </body>
</html>

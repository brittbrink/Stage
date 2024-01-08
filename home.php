<?php 

session_start();
include "config.php";

// functie gedefinieerd voor het ophalen van de gecertificeerde scopes van een gebruiker.
function OphalenGebruikerScope($sessie_ID, $conn)
{
    $sql = "SELECT * FROM `gebruikerscope` WHERE Gebruiker_ID='$sessie_ID' AND Gecertificeerd=true";
    $result = mysqli_query($conn, $sql);

    if($result){
        while($row=mysqli_fetch_assoc($result)){
            $ScopeID=$row['Scope_ID'];
            $GebruikerID=$row['Gebruiker_ID'];
            $gecertificeerd=$row['Gecertificeerd'];
            $inzien=$row['Alleen_lezen'];

            echo "Scope id: " . $ScopeID;
            echo '<br>'; 
            echo "Gebruikers id: " . $GebruikerID;
            echo '<br>';
            echo "Gecertificeerd? " . $gecertificeerd;
            echo '<br>';
            echo "Inzien? " . $inzien;
            
        }
    }

}


if (isset($_SESSION['ID']) && isset($_SESSION['gebruikersnaam'])) {

?>

<!DOCTYPE html>
<html>
<head>

    <title>HOME</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">


</head>
<body>
    <div></div>
    <h1>Hello, <?php echo $_SESSION['gebruikersnaam']; ?>.</h1>
    </br> 
    <?php OphalenGebruikerScope($_SESSION['ID'], $conn); ?> 

    </br>
    <a href="logout.php">Logout</a>

</body>
</html>

<?php 
}
else{
   
    header("Location: index.php");
    exit();
}

?>
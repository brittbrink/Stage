<?php 

session_start();
include "config.php";
include "navbar.php";

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

            echo '<br>';
            echo "Scope id: " . $ScopeID;
            echo '<br>'; 
            echo "Gebruikers id: " . $GebruikerID;
            echo '<br>';
            echo "Gecertificeerd? " . $gecertificeerd;
            echo '<br>';
            echo "Inzien? " . $inzien;
            
            ScopeGebruiker($ScopeID, $conn);
        }
    }

}

function ScopeGebruiker($ID_Scope, $conn)
{
    $sql = "SELECT * FROM `scope` WHERE ID='$ID_Scope'";
    $result = mysqli_query($conn, $sql);

    if($result){
        while($row=mysqli_fetch_assoc($result)){
            $scopeId=$row['ID'];
            $scopeNummer=$row['Nummer'];
            $omschrijving=$row['Omschrijving'];

            echo '<br>';
            echo "Scope id: " . $scopeId;
            echo '<br>'; 
            echo "Nummer scope: " . $scopeNummer;
            echo '<br>';
            echo "Omschrijving van de scope: " . $omschrijving;
                 
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
    <link rel="stylesheet" href="style.css">


</head>
<body>
    <div class="container mx-1 my-4">
    <div class="row justify-content-start">
        <div class="col-6 col-md-4">
            <div class="oval"></div>
            <div class="line-vertical arrow-down"></div>
            <div class="oval"></div>
            <div class="line-vertical arrow-down"></div>
            <div class="oval"></div>
        </div>
        <div class="col-12 col-md-4">
            <h1>Hello, <?php echo $_SESSION['gebruikersnaam']; ?>.</h1>
            </br> 
            <?php OphalenGebruikerScope($_SESSION['ID'], $conn); ?> 
        </div>
    </div>
    </div>

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
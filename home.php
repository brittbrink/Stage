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
            <div class="oval">
                <span class="text">Locatie toevoegen</span>
            </div>
            <div class="line-vertical arrow-down"></div>
            <div class="oval">
                <span class="text">Bedrijf toevoegen</span>
            </div> 
            <div class="line-vertical arrow-down"></div>
            <div class="oval">
                <span class="text">Installatie bekijken</span>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <h1>Hello, <?php echo $_SESSION['gebruikersnaam']; ?>.</h1>
            </br> 
        </div>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLongTitle">Kruis een scope/meerdere scopes aan die u wilt toevoegen om in te zien naast uw gecertificeerde scope(s): </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php OphalenGebruikerScope($_SESSION['ID'], $conn); ?> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <a href="logout.php">Logout</a>

    <script>
        $('#myModal').modal('show')
    </script>
</body>
</html>

<?php 
}
else{
   
    header("Location: index.php");
    exit();
}

?>
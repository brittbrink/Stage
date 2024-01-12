<?php 

session_start();
include "config.php";
include "navbar.php";

// functie gedefinieerd voor het ophalen van de gecertificeerde scopes van een gebruiker.
function OphalenGebruikerScopeGecertificeerd($sessie_ID, $conn)
{
    $sql = "SELECT * FROM `gebruikerscope` WHERE Gebruiker_ID='$sessie_ID' AND Gecertificeerd=true";
    $result = mysqli_query($conn, $sql);

    if($result){
        while($row=mysqli_fetch_assoc($result)){
            $ScopeID=$row['Scope_ID'];
            $GebruikerID=$row['Gebruiker_ID'];
            $gecertificeerd=$row['Gecertificeerd'];
            $inzien=$row['Alleen_lezen'];

            // echo '<br>';
            // echo "Scope id: " . $ScopeID;
            // echo '<br>'; 
            // echo "Gebruikers id: " . $GebruikerID;
            // echo '<br>';
            // echo "Gecertificeerd? " . $gecertificeerd;
            // echo '<br>';
            // echo "Inzien? " . $inzien;
            
            ScopeGebruikerGecertificeerd($ScopeID, $conn);
        }
    }

}

function ScopeGebruikerGecertificeerd($ID_Scope, $conn)
{
    $sql = "SELECT * FROM `scope` WHERE ID='$ID_Scope'";
    $result = mysqli_query($conn, $sql);

    if($result){
        while($row=mysqli_fetch_assoc($result)){
            $scopeId=$row['ID'];
            $scopeNummer=$row['Nummer'];
            $omschrijving=$row['Omschrijving'];

            // echo '<br>';
            // echo "Scope id: " . $scopeId;
            echo '<br>'; 
            echo "Scope " . $scopeNummer;
            // echo '<br>';
            // echo "Omschrijving van de scope: " . $omschrijving;
                 
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css"> <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"> <!-- CSS -->
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="container mx-1 my-4">
    <div class="row justify-content-start">
        <div class="col-6 col-md-4">
            <div class="step step-active">
            <div>
                <div class="circle">1</div>
            </div>
            <div>
                <div class="title">Eerste stap</div>
                <div class="caption">Een locatie toevoegen aan uw verzameling.</div>
            </div>
            </div>
            <div class="step">
            <div>
                <div class="circle">2</div>
            </div>
            <div>
                <div class="title">Tweede stap</div>
                <div class="caption">Een bedrijf toevoegen aan de locatie.</div>
            </div>
            </div>
            <div class="step">
            <div>
                <div class="circle">3</div>
            </div>
            <div>
                <div class="title">Derde stap</div>
                <div class="caption">De installaties bekijken van het bedrijf.</div>
            </div>
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
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                            <label class="form-check-label" for="inlineCheckbox1">1</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                            <label class="form-check-label" for="inlineCheckbox2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3" disabled>
                            <label class="form-check-label" for="inlineCheckbox3"><?php OphalenGebruikerScopeGecertificeerd($_SESSION['ID'], $conn) ; ?> </label>
                        </div>
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
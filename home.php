<?php 

session_start();
include "config.php";
include "navbar.php";
$cert= true;


// Functie gedefinieerd voor het ophalen van de gecertificeerde scopes van een gebruiker.
function OphalenGebruikerScopeGecertificeerd($sessie_ID, $conn, $cert)
{
    $sql = "SELECT s.Scope_Nummer FROM gebruikerscope gs JOIN scope s ON s.Scope_Nummer = gs.Scope_Nummer WHERE gs.Gebruiker_ID = '$sessie_ID' AND gs.Gecertificeerd=$cert";
    $result = mysqli_query($conn, $sql);
    if($result){
        $i = 0;
        $gebruikerdata = [];
        while($row=mysqli_fetch_assoc($result)){

            $gebruikerdata[$i] = $row['Scope_Nummer'];
            $i = $i + 1;
        }
        if($gebruikerdata){
            return $gebruikerdata;
        }
        else{
            return [];
        } 
    }
}

// Functie voor het ophalen van alle scopes.
function OphalenScopes($conn)
{
    $sql = "SELECT Scope_Nummer FROM `scope`";
    $result = mysqli_query($conn, $sql);

    if($result){
        $i = 0;
        $scopedata= [];
        while($row=mysqli_fetch_assoc($result)){
            
            $scopedata[$i] = $row['Scope_Nummer'];
            $i = $i + 1;  
        }
        if($scopedata){
            return $scopedata;
        }
        else{
            return null;
        }
       
    }
}

// Functie voor het kijken of het de eerste popup van de gebruiker is.
function FirstPopUp($sessie_ID, $conn)
{
    $statuspopup = false;
    $sql = "SELECT popup FROM gebruiker WHERE `ID`='$sessie_ID'";
    $result = mysqli_query($conn, $sql);

    if($result){
        while($row=mysqli_fetch_assoc($result)){
            $statuspopup = $row['popup'];

        }

    }
    return $statuspopup;
}

// Het updaten van de popup zodat de gebruiker de volgende keer niet weer de popup krijgt na het inloggen.
function UpdatePopUp($sessie_ID, $conn)
{
    $sql = "UPDATE gebruiker SET `popup`= 1 WHERE `ID`= '$sessie_ID'"; 
    $result = mysqli_query($conn, $sql);

}

// De scopes die worden aangevinkt door de gebruiker opslaan in de database als readonly.
function InsertCheckboxValue($sessie_ID, $conn, $checkedScope)
{
    foreach($checkedScope as $scope){
        $sql = "INSERT INTO `gebruikerscope`(`Scope_Nummer`, `Gebruiker_ID`, `Gecertificeerd`, `Alleen_lezen`) VALUES ('$scope','$sessie_ID','0','1')"; 
        $result = mysqli_query($conn, $sql);
        if(! $result){
            echo "Fout bij toevoegen van scope $scope";
        }
    }

}

// Functie voor het ophalen van locaties die al bestaan in de database
function OphalenLocatie($conn)
{
    $sql = "SELECT * FROM `locatie`";
    $result = mysqli_query($conn, $sql);
    $locatiedata = [];
    if($result){
        while($row=mysqli_fetch_assoc($result)){
            $id=$row['ID'];
            $adres=$row['Adres'];
            $huisnummer=$row['Huisnummer'];
            $toevoeging=$row['Toevoeging'];
            $plaats=$row['Plaats'];
            $postcode=$row['Postcode'];

            echo $adres . " " . $huisnummer . ", " . $plaats;

        }
    }
    
}
// Het gebruiken van de informatie die uit het inloggen komt.
if (isset($_SESSION['ID']) && isset($_SESSION['gebruikersnaam'])) {

?>

<!DOCTYPE html>
<html>
<head>

    <title>HOME</title>

    <!-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"> -->
    <!-- <link rel="stylesheet" href="style.css"> -->

    <!-- Voor werkend maken van modal -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">

</head>
<body>
    <div class="container mx-1 my-4">
    <div class="row justify-content-start">
        <form method="POST">
            <?php  
                // Als de eerste popup false is en nog niet is gedisplayed wordt de popup (modal) weergegeven.
                if(! FirstPopUp($_SESSION['ID'], $conn))
                {
            ?>
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
                                    <?php 
                                    // Geeft alle scopes weer waarvoor de gebruiker niet gecertificeerd is.
                                    // Sorteert op ASCI en niet op nummer want Scope_Nummer is varchar.
                                    $resultScopes = OphalenScopes($conn);
                                    $resultGebruiker = OphalenGebruikerScopeGecertificeerd($_SESSION['ID'], $conn, true);
                                    $count = array_diff($resultScopes, $resultGebruiker);
                                    if($count){
                                        foreach($count as $value) { 
                                        ?>                      
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="scope[]" value="<?php echo $value ?>">
                                            <label class="form-check-label" for="inlineCheckbox2">
                                                <?php
                                                echo $value;
                                            ?>
                                            </label>   
                                        </div>
                                        <?php
                                        }}
                                        ?>
                                    <?php 
                                    // Geeft de scopes weer waarvoor de gebruiker gecertificeerd is.
                                    $count = OphalenGebruikerScopeGecertificeerd($_SESSION['ID'], $conn, true);
                                    if($count){
                                        foreach($count as $value) { 
                                        ?>                      
                                    <div class="form-check form-check-inline">
                                        <input disabled class="form-check-input" type="checkbox">
                                        <label class="form-check-label" for="inlineCheckbox3"> 
                                            <?php
                                            echo $value;
                                            ?>
                                        </label>   
                                    </div>
                                    <?php
                                        }}
                                    ?>
                                </div>
                                <div class="modal-footer">
                                    <!-- Zorgt ervoor dat de popup na de eerste keer inoggen niet meer wordt weergegeven. -->
                                    <?php UpdatePopUp($_SESSION['ID'], $conn); ?> 
                                    <button type="submit" class="btn btn-success">Opslaan</button> 
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
                
            ?>
        </form>
        <div class="col-3 col-md-4">
            <!-- link naar de stappen timeline: https://codeconvey.com/pure-css-vertical-stepper/ --> 
            <div class="step step-active"> 
            <div>
                <div class="circle">1</div>
            </div>
            <div>
                <div class="title">Eerste stap</div>
                <div class="caption">Een locatie toevoegen aan uw collectie.</div>
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
        <div class="col-6 col-md-5">
            <h3>Hallo, <?php echo $_SESSION['gebruikersnaam']; ?>.</h3>
            </br> 
            <?php 
            // De scopes die zijn aangevinkt door de gebruiker worden opgeslagen als readonly in de database.
            if(isset($_POST['scope'])){
                InsertCheckboxValue($_SESSION['ID'], $conn, $_POST['scope']);
            }  
            ?>
        </div>
        <div class="col-3 col-md-3">
            <h3>Uw locaties: </h3>
            <ul class="list-group my-3">
                <?php
                    $locaties = OphalenLocatie($conn);
                    foreach($locaties as $locatie){
                    
                ?>
                <a class="list-group-item d-flex justify-content-between align-items-center" data-bs-toggle="list" href="bedrijf.php" role="tab">
                    <!-- <span class="btn btn-outline-success"></span> -->
                    <?php
                        echo $value;
                    ?>
                </a>
                <?php  
                    }
                ?>
                <li class="list-group-item d-flex justify-content-between align-items-center" style="border-top-width: 1;">
                    Locatie 2
                    <span class="badge bg-success rounded-pill">2</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center" style="border-top-width: 1;">
                    Locatie 3
                    <span class="badge bg-success rounded-pill">1</span>
                </li>
            </ul>
            <!-- <ul class="list-group">
                <li class="list-group-item" style="border-top-width: 1;">An item</li>
                <li class="list-group-item" style="border-top-width: 1;">A second item</li>
                <li class="list-group-item" style="border-top-width: 1;">A third item</li>
                <li class="list-group-item" style="border-top-width: 1;">A fourth item</li>
                <li class="list-group-item" style="border-top-width: 1;">And a fifth one</li>
            </ul> -->
        </div>

    </div>
    <div class="row">
        <div class="col-3 col-md-4">
            <a href="logout.php" class="btn btn-outline-success my-3">Uitloggen</a>
        </div>
        <div class="col-3 col-md-5">
        </div>
        <div class="col-auto">
        <a href="bedrijf.php" class="btn btn-outline-success my-3">Volgende</a>
        </div>

            
    </div>
    </div>

    <script>
        $('#myModal').modal('show')
        //myModal.show()
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
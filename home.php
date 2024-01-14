<?php 

session_start();
include "config.php";
include "navbar.php";
$cert= true;


// functie gedefinieerd voor het ophalen van de gecertificeerde scopes van een gebruiker.
function OphalenGebruikerScopeGecertificeerd($sessie_ID, $conn, $cert)
{
    $sql = "SELECT s.Nummer FROM gebruikerscope gs JOIN scope s ON s.ID = gs.Scope_ID WHERE gs.Gebruiker_ID = '$sessie_ID' AND gs.Gecertificeerd=$cert";
    $result = mysqli_query($conn, $sql);
    if($result){
        $i = 0;
        $gebruikerdata = [];
        while($row=mysqli_fetch_assoc($result)){

            $gebruikerdata[$i] = $row['Nummer'];
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

// functie voor het ophalen van alle scopes.
function OphalenScopes($conn)
{
    $sql = "SELECT Nummer FROM `scope`";
    $result = mysqli_query($conn, $sql);

    if($result){
        $i = 0;
        $scopedata= [];
        while($row=mysqli_fetch_assoc($result)){
            
            $scopedata[$i] = $row['Nummer'];
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
                        
                        <?php 
                        $resultScopes = OphalenScopes($conn);
                        $resultGebruiker = OphalenGebruikerScopeGecertificeerd($_SESSION['ID'], $conn, true);
                        $count = array_diff($resultScopes, $resultGebruiker);
                        if($count){
                            foreach($count as $value) { 
                            ?>                      
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id=<?php $value ?>>
                                <label class="form-check-label" for="inlineCheckbox2">
                                    <?php
                                    echo $value;
                                    //echo "<br>";
                                ?>
                                </label>   
                            </div>
                            <?php
                            }}
                            ?>
                        <?php 
                        $count = OphalenGebruikerScopeGecertificeerd($_SESSION['ID'], $conn, true);
                        if($count){
                            foreach(OphalenGebruikerScopeGecertificeerd($_SESSION['ID'], $conn, true) as $value) { 
                            ?>                      
                        <div class="form-check form-check-inline">
                            <input disabled class="form-check-input" type="checkbox" id=<?php $value ?> >
                            <label class="form-check-label" for="inlineCheckbox3"> 
                                <?php
                                echo $value;
                                //echo "<br>";
                             ?>
                            </label>   
                        </div>
                        <?php
                            }}
                        ?>
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

    <a href="logout.php" class="btn btn-primary mx-3">Logout</a>

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
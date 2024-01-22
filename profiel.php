<?php

session_start();
include "config.php";
include "navbar.php";
$readonly = true;
$cert = true;

// Gebruikers readonly scopes ophalen
function OphalenGebruikerScopeLezen($sessie_ID, $conn, $readonly)
{
    $sql = "SELECT s.Scope_Nummer FROM gebruikerscope gs JOIN scope s ON s.Scope_Nummer = gs.Scope_Nummer WHERE gs.Gebruiker_ID = '$sessie_ID' AND gs.Alleen_lezen=$readonly";
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

// Functi voor het ophalen van alle scopes.
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

// Functie voor het verwijderen van de scope om niet meer in te zien in het portaal.
function DeleteScopeLezen($sessie_ID, $conn, $scope)
{
    foreach($scope as $s ){
        $sql = "DELETE FROM gebruikerscope WHERE `Scope_Nummer`='$s' AND `Gebruiker_ID`='$sessie_ID'"; 
        //echo "hallo in de delete functie";
        $result = mysqli_query($conn, $sql);
        // if(! $result){
        //     echo "Fout bij verwijderen van scope $s.";
        // }
    }


}

// Functie voor het toevoegen van de scope om in te zien in het portaal.
function InsertScopeLezen($sessie_ID, $conn, $checkedScope)
{
    foreach($checkedScope as $scope){
        $sql = "INSERT INTO `gebruikerscope`(`Scope_Nummer`, `Gebruiker_ID`, `Gecertificeerd`, `Alleen_lezen`) VALUES ('$scope','$sessie_ID','0','1')"; 
        $result = mysqli_query($conn, $sql);
        // if(! $result){
        //     echo "Fout bij toevoegen van scope $scope.";
        // }
    }

}

// Het gebruiken van de informatie die uit het inloggen komt.
if (isset($_SESSION['ID']) && isset($_SESSION['gebruikersnaam'])) {
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profiel</title>
</head>
<body>
<div class="container mx-1 my-4">
    <h3> Profiel van <?php echo $_SESSION['gebruikersnaam']; ?>! </h3>
    <form method="POST">
        <div class="card" style="width: 25rem;">
            <div class="card-body">
                <h5 class="card-title">De scopes die aangevinkt zijn om in te zien in het portaal:</h5>
                <p class="card-text">
                <?php
                // Geeft de scopes weer die de gebruiker wil lezen in het portaal.
                $count = OphalenGebruikerScopeLezen($_SESSION['ID'], $conn, true);
                if($count){
                    foreach($count as $value) { 
                ?>    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="scopeLezen[]" value="<?php echo $value ?>" id="flexCheck">
                        <label class="form-check-label" for="flexCheck">
                            <?php
                                echo $value;
                            ?>
                        </label>
                    </div>                  
                <?php
                    }}
                ?>
                </p>
            </div>
        </div>
        <div class="card my-3" style="width: 25rem;">
            <div class="card-body">
                <h5 class="card-title">De scopes die nog aangevinkt kunnen worden om in te zien in het portaal:</h5>
                <p class="card-text">
                <?php
                // Geeft de scopes weer die de gebruiker wil lezen in het portaal.
                $resultScopes = OphalenScopes($conn);
                $resultGebruikerGecertificeerd = OphalenGebruikerScopeGecertificeerd($_SESSION['ID'], $conn, true);
                $resultGebruikerLezen = OphalenGebruikerScopeLezen($_SESSION['ID'], $conn, true);
                $count = array_diff($resultScopes, $resultGebruikerGecertificeerd, $resultGebruikerLezen);
                if($count){
                    foreach($count as $value) { 
                ?>                      
                    <div class="form-check form-check-inline mx-3">
                        <input class="form-check-input" type="checkbox" name="UpdateScopeLezen[]" value="<?php echo $value ?>" id="flexCheck">
                        <label class="form-check-label" for="flexCheck">
                            <?php
                                echo $value;
                            ?>
                        </label>
                    </div>
                <?php
                    }}
                ?>
                </p>
            </div>
        </div>
        <button type="submit" class="btn btn-outline-success">Opslaan</button>  
    </form>  
    <?php 

        // De scopes die niet meer aangevinkt zijn worden verwijderd.
        if(isset($_POST['scopeLezen'])){
            DeleteScopeLezen($_SESSION['ID'], $conn, $_POST['scopeLezen']);

        }  
        // Toevoegen van de scopes die zijn aangevinkt om in te zien.
        if(isset($_POST['UpdateScopeLezen'])){
            InsertScopeLezen($_SESSION['ID'], $conn, $_POST['UpdateScopeLezen']);
        } 

    ?>
</div>
</body>
</html>
<?php 
}
else{
   
    header("Location: index.php");
    exit();
}

?>
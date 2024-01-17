<?php

session_start();
include "config.php";
include "navbar.php";
$readonly = true;

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

// Het gebruiken van de informatie die uit het inloggen komt.
if (isset($_SESSION['ID']) && isset($_SESSION['gebruikersnaam'])) {
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<div class="container mx-1 my-4">
    <h3> Profiel van <?php echo $_SESSION['gebruikersnaam']; ?>! </h3>
    <div class="card" style="width: 25rem;">
        <div class="card-body">
            <h5 class="card-title">De scopes die aangevinkt zijn om in te zien in het portaal:</h5>
            <p class="card-text">
            <?php
            // Geeft de scopes weer die de gebruiker wil lezen in het portaal.
            $count = OphalenGebruikerScopeLezen($_SESSION['ID'], $conn, true);
            if($count){
                foreach(OphalenGebruikerScopeLezen($_SESSION['ID'], $conn, true) as $value) { 
            ?>                      
                <div class="form-check form-check-inline mx-3">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                    <label class="form-check-label" for="flexCheckChecked">
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
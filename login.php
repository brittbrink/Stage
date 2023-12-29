<?php
session_start();
include "config.php";

if (isset($_POST['gebruikersnaam']) && isset($_POST['wachtwoord'])){
    // Alle tekens die niet behoren tot de naam worden weggehaald.
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
        // De gestripte data toekennen aan variabele.
    $gebruikersnaam = validate($_POST['gebruikersnaam']);
    $wachtwoord = validate($_POST['wachtwoord']);

    //$gebruikersnaam = $_POST['gebruikersnaam'];
    //$wachtwoord = $_POST['wachtwoord'];

        // Als het veld van de gebruikersnaam leeg is, wordt er teruggegaan naar de index.php pagina.
    if (empty($gebruikersnaam)){
        header("Location: index.php?error=Gebruikersnaam is vereist.");
        exit();
    }
        // Als het veld van het wachtwoord leeg is, wordt er teruggegaan naar de index.php pagina.
    else if(empty($wachtwoord)){
        header("Location: index.php?error=Wachtwoord is vereist.");
        exit();
    }
    else{
            // Query uitvoeren om te checken of de gebruiker in de database staat.
        $sql = "SELECT * FROM `gebruiker` WHERE Gebruikersnaam='$gebruikersnaam' AND Wachtwoord='$wachtwoord'";
        $result = mysqli_query($conn, $sql);
            // Checken of vanuit de query er een rij resultaat uitkomt.
        
        if (mysqli_num_rows($result) === 1){
            $row = mysqli_fetch_assoc($result);
            
            if($row['Gebruikersnaam'] === "$gebruikersnaam" && $row['Wachtwoord'] === "$wachtwoord"){
                echo "U bent ingelogt!";
                $_SESSION['gebruikersnaam'] = $row['Gebruikersnaam'];
                $_SESSION['ID'] = $row['ID'];
                header("Location: home.php");
                exit();
            }
            else{
                header("Location: index.php?error= Gebruikersnaam of wachtwoord niet gevonden.");
                exit(); 
            }
        }
        else{
            header("Location: index.php?error= Gebruikersnaam of wachtwoord incorrect.");
            //echo "<p style='color: red'>Gebruiker niet gevonden</p>";
            exit(); 
        }
    }
}
else{
    header("Location: index.php?error = else-tak of first if");
    exit(); 
}
?>
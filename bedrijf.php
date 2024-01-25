<?php 

session_start();
include "config.php";
include "navbar.php";

// Functie voor het ophalen van bedrijven die al bestaan op de locatie.
function OphalenBedrijf($conn)
{
    $sql = "SELECT * FROM `bedrijf`";
    $result = mysqli_query($conn, $sql);
    $locatiedata = [];
    if($result){
        while($row=mysqli_fetch_assoc($result)){
            $id=$row['ID'];
            $firmanaam=$row['Firmanaam'];
            $kvknummer=$row['KvK-nummer'];
            $vestigingsnummer=$row['Vestigingsnummer'];
            $sbicode=$row['SBI_code'];

            echo $firmanaam;

        }
    }
    
}


// Het gebruiken van de informatie die uit het inloggen komt.
if (isset($_SESSION['ID']) && isset($_SESSION['gebruikersnaam'])) {
?>


<!DOCTYPE html>
<html>
<head>

    <title>Bedrijf toevoegen</title>

</head>
<body>
    <div class="container mx-1 my-4">
    <div class="row justify-content-start">
        <div class="col-3 col-md-4">
            <!-- link naar de stappen timeline: https://codeconvey.com/pure-css-vertical-stepper/ --> 
            <div class="step"> 
            <div>
                <div class="circle">1</div>
            </div>
            <div>
                <div class="title">Eerste stap</div>
                <div class="caption">Een locatie toevoegen aan uw verzameling.</div>
            </div>
            </div>
            <div class="step step-active">
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
            <h3>Bedrijf toevoegen:</h3>
            <form method="POST">
                <div class="mb-3 row">
                    <label for="Firma" class="col-sm-4 col-form-label">Firmanaam:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="Firma">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="kvknummer" class="col-sm-4 col-form-label">KvK-nummer:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="kvknummer">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="Vestigingsnummer" class="col-sm-4 col-form-label">Vestigingsnummer:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="Vestigingsnummer">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="sbicode" class="col-sm-4 col-form-label">SBI-code:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="sbicode">
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-success">Opslaan</button> 
            </form> 
        </div>
        <div class="col-3 col-md-3">
            <h4>Bestaande bedrijven op deze locatie: </h4>
            <ul class="list-group my-3">
                <a class="list-group-item d-flex justify-content-between align-items-center" data-bs-toggle="list" href="installatie.php" role="tab">
                    <!-- <span class="btn btn-outline-success"></span> -->
                    <?php
                        OphalenBedrijf($conn); 
                    ?>
                </a>
                
            </ul> 
        </div>


    </div>
    <div class="row">
        <div class="col-3 col-md-4">
            <a href="logout.php" class="btn btn-outline-success my-3">Logout</a>
        </div>
        <div class="col-3 col-md-5">
        </div>
        <!-- <div class="col-auto">
        <a href="installatie.php" class="btn btn-outline-success my-3">volgende</a>
        </div> -->

            
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
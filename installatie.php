<?php 

session_start();
include "config.php";
include "navbar.php";



// Het gebruiken van de informatie die uit het inloggen komt.
if (isset($_SESSION['ID']) && isset($_SESSION['gebruikersnaam'])) {
?>


<!DOCTYPE html>
<html>
<head>

    <title>Installaties bekijken</title>

</head>
<body>
    <div class="container mx-1 my-4">
    <div class="row justify-content-start">
        <div class="col-6 col-md-4">
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
            <div class="step">
            <div>
                <div class="circle">2</div>
            </div>
            <div>
                <div class="title">Tweede stap</div>
                <div class="caption">Een bedrijf toevoegen aan de locatie.</div>
            </div>
            </div>
            <div class="step step-active">
            <div>
                <div class="circle">3</div>
            </div>
            <div>
                <div class="title">Derde stap</div>
                <div class="caption">De installaties bekijken van het bedrijf.</div>
            </div>
            </div>
        </div>
        <div class="col-12 col-md-8">
            <h3>Installaties bekijken:</h3>
            </br> 
        </div>

    </div>
    <div class="row">
        <div class="col-6 col-md-4">
            <a href="logout.php" class="btn btn-outline-success my-3">Logout</a>
        </div>
        <div class="col-12 col-md-8">
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
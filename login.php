<!DOCTYPE html>
<html lang="en">
  <head>
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> PHP CRUD </title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">

  </head>
    <body>
        <div style="height: 700px;" class="d-flex align-items-center justify-content-center">
            <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="./Afbeeldingen/SCIOS-logo.png" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">Inloggen</h5>
                <form method="POST">
                    <div class="form-group">
                    Gebruikersnaam:
                    <input type="text" class="form-control" 
                    placeholder="Vul uw gebruikersnaam in." 
                    name="gebruikersnaam" autocomplete="off">
                    </div>

                    <div class="form-group">
                    Wachtwoord:
                    <input type="text" class="form-control" 
                    placeholder="Vul uw wachtwoord in." 
                    name="wachtwoord" autocomplete="off">
                    </div>
                
                    
                    <button type="submit" class="btn btn-primary" name="inloggen">Inloggen</button>
                    
                </form>
            </div>
            </div>
        </div>
    </body>

</html>

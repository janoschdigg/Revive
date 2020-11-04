<?php

session_start();
if($_SESSION["logedin"] === "yes")
{

}
else
{
    header("Location: login.php");
}

?>

<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>Neue Aktivität</title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <img class="logo" src="../images/churches/iconbird.svg">
    <a class="navbar-brand" href="#">Revive Admin</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse">
        <div class="navbar-nav" style="width: 100%;">
            <a class="nav-link active" href="index.php">Home</a>
            <a class="nav-link" href="newActivity.php">Neue Aktivität</a>
            <a class="nav-link float-right" href="login.php?logout=true">Log Out</a>

        </div>
    </div>

 
    </nav>
    <main>
        <h2>Neue Aktivität erstellen</h2>
        <form action="index.php" method="POST">
            <div class="form-group">
                <label for="exampleFormControlInput1">Titel</label>
                <input name="title" required type="text" class="form-control" placeholder="bsp. Fussball Sonntag Nachmittag">
            </div>
            <div class="form-row">
                <div class="col">
                    <label for="exampleFormControlInput1">Datum</label>
                    <input name="date" required type="date" class="form-control" >
                </div>
                <div class="col">
                    <label for="exampleFormControlInput1">Zeit</label>
                    <input name="time" required type="time" class="form-control" >
                </div>
            </div><br>
            <div class="form-group">
                <label for="exampleFormControlInput1">Ort</label>
                <input name="location" required type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">max. Teilnehmer</label>
                <input name="participants" required type="number" class="form-control" >
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Kategorie</label>
                <select name="category" class="form-control" id="exampleFormControlSelect1">
                    <option value="1">S.O.S</option>
                    <option value="2">Outreach</option>
                    <option value="3">Event</option>
                </select>
            </div>
           
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Beschreibung</label>
                <textarea name="body" required class="form-control" rows="4"></textarea>
            </div>
            <div class="form-group">
                <input name="submit" type="submit" Value="Speichern" class="form-control" >
            </div>

        </form>
    </main>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

  </body>
</html>
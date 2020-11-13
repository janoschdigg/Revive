<?php

session_start();
if($_SESSION["logedin"] === "yes")
{
  if($_SESSION["isadmin"] === "1"){}
  else{
    header("Location: index.php");
  }
}
else
{
    header("Location: login.php");
}

require('../phpscripts/connection.php');
$con = new Connection();


?>

<!doctype html>
<html lang="de">
  <head>
    <?php require('head.php'); ?>

    <title>Passwort ändern</title>
  </head>
  <body>
  <?php require('navigation.php'); ?>

<main>
<div class="card klein">
            <h4 class="card-header">Passwort ändern</h4>
            <div class="card-body ">
                <form action="changepw.php" method="POST"> 
                    <div class="form-group">
                        <label for="old">Altes Passwort</label>
                        <input  maxlength="30" required type="password" name="old" class="form-control" id="old" aria-describedby="emailHelp" placeholder="Altes Passwort">
                    </div>   
                    <div class="form-group">
                        <label for="new">Neues Passwort</label>
                        <input maxlength="30"  required type="password" name="new" class="form-control" id="new" aria-describedby="emailHelp" placeholder="Neues Passwort">
                    </div>  
                    <div class="form-group">
                        <label for="new2">Passwort bestätigen</label>
                        <input maxlength="30" required type="password" name="new2" class="form-control" id="new2" aria-describedby="emailHelp" placeholder="Passwort bestätigen">
                    </div>  
                    <button type="submit" name="button" class="btn btn-secondary">Passwort ändern</button> 
                </form>
            </div>
      </div>

</main>

  </body>
</html>

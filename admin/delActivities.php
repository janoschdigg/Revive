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

    <title>Aktivitätenverwaltung</title>
  </head>
  <body>
  <?php require('navigation.php'); ?>

<main>


</main>

  </body>
</html>

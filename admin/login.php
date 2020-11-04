<?php
session_start();
if(isset($_GET['logout']))
{
  unset($_SESSION['logedin']);
  session_destroy();

}
if(isset($_POST['username'])&&isset($_POST['password']))
{
    require('../phpscripts/connection.php');
    $con = new Connection();

    $result = $con->sqlexec("Select * from revive.user");
    
    foreach($result as $key => $value){
    if($_POST['username'] === $value['username'])
      {
        if($_POST['password'] === $value['password'])
        {
          $_SESSION["logedin"] = "yes";
          $_SESSION["userid"] = $value['id'];
          $_SESSION["username"] = $value['name'];
          $_SESSION["churchid"] = $value['fchurchid'];

          header("Location: index.php");
        }
      }
    }

    $false = "<b>Anmeldedaten nicht korrekt!</b>";
   

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revive LogIn</title>
    <link rel="stylesheet" href="loginstyle.css">

</head>
<body>
<div class="login-page">
  <div class="form">
      <h2>Revive LogIn</h2>
      <?php if(isset($false)) {echo("<p class='banner'>". $false ."</p>");} ?>
    <form class="login-form" action="#" method="POST">
      <input type="text" name="username" placeholder="Benutzername"/>
      <input type="password" name="password" placeholder="Passwort"/>
      <button>Anmelden</button>
    </form>
  </div>
</div>
</body>
</html>
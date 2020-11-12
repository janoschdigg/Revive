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

if(isset($_POST['delete']))
{
  $con->sqlexec("UPDATE user set deleted = 1 where id = " .$_POST['delete']);
  header("Location: user.php");

}

if(isset($_POST['submit']) || isset($_POST['update']))
{
    $id = $_POST['id'];

    $username = $_POST['username'];
    $name = $_POST['name'];
    $mail = $_POST['mail'];
    $password = $_POST['password'];
    $secondpassword = $_POST['secondpassword'];
    $category = $_POST['category'];
    $body = $_POST['body'];

    $fchurchid = $_POST['fchurchid'];

    if(isset($_POST['update']))
    {
        $con->sqlexec("UPDATE activity set title = '$title', body = '$body', date = '$date', time = '$time', location = '$location', participants = $participants, fcategoryID = $category, deleted = 0 where id = '$id'");
    }
    else{
        $con->sqlexec("INSERT INTO user(id, username, name, password, fchurchid, mail, isadmin, deleted) VALUES (null,'$username','$name','$password','$fchurchid', '$mail',0,0)");

    }

    header("Location: user.php");
}


?>

<!doctype html>
<html lang="de">
  <head>
    <?php require('head.php'); ?>

    <title>Benutzerverwaltung</title>
  </head>
  <body>
  <?php require('navigation.php'); ?>

<main>
  <div class="row">
    <div class="col-sm-12 col-md-4 mb-2">
        <div class="card" >
            <h5 class="card-header"><b>Neuer Benutzer</b></h5>
            <div class="card-body">
            <form action="user.php" method="POST">
              <div class="form-group">
                <label for="exampleFormControlInput1">Benutzername</label>
                <input type="text" name="username" class="form-control" >
              </div>
              <div class="form-group">
                <label for="exampleFormControlInput1">Name</label>
                <input type="text" name="name" class="form-control" >
              </div>
              <div class="form-group">
                <label for="exampleFormControlInput1">Mail</label>
                <input type="text" name="mail" class="form-control" >
              </div>
              <div class="form-group">
                <label for="exampleFormControlInput1">Passwort</label>
                <input type="password" name="password" class="form-control" >
              </div>
              <div class="form-group">
                <label for="exampleFormControlInput1">Passwort wiederholen</label>
                <input type="password" name="secondpassword" class="form-control" >
              </div>
              <div class="form-group">
              <div class="form-group">
                <label for="exampleFormControlSelect1">Kirche</label>
                <select name="fchurchid" class="form-control" id="exampleFormControlSelect1">
                  <?php 
                  $data = $con->sqlexec("Select * from revive.church"); 
                  foreach($data as $key => $value)
                  {
                    echo "
                    <option value='".$value['id']."'> ".$value['name']."</option>
                    ";
                  }
                  ?>
                </select>
              </div>
              </div>
              <div class="form-group">
                <input type="text" name="id" class="form-control d-none" >
                <input type="submit" name="submit" value="Speichern" class="form-control" >
              </div>
            </form>
            </div>
            
        </div>    
    </div>
    <div class="col-sm-12  col-md-8">
        <div class="card" >
            <h5 class="card-header"><b>Bestehende Benutzer</h5>
            <div class="card-body">
            <table class="table ">
                    <thead style="text-align: left;">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Benutzername</th>
                            <th scope="col">Name</th>
                            <th scope="col">Mail</th>

                            <th scope="col">Kirche</th>
                            <th scope="col">Aktion</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: left;">
                        <?php
                            $counter = 0;
                            $data = $con->sqlexec("Select user.id, username, user.name as name, mail, church.name as churchname  from revive.user INNER JOIN church ON user.fchurchid = church.id where deleted = 0 "); 
                            foreach($data as $key => $value)
                            {
                                $counter++;
                                echo "
                                <tr>
                                <td><b>".$counter."</b></td>
                                <td>".$value['username']."</td>
                                <td>".$value['name']."</td>
                                <td>".$value['mail']."</td>
                                <td>".$value['churchname']."</td>
                                <td>
                                    <button type='button' onclick='editUser(". $value['id'] .")' class='btn btn-primary'>Bearbeiten</button>

                                    <button type='button' onclick='del(". $value['id'] .")' class='btn btn-danger'>Löschen</button>
                                    <form style='display: none' action='#' method='POST'>
                                        <input type='submit' name='delete' id='del".$value['id']."' value='".$value['id']."'>
                                    </form>
                                </td>
                            </tr>
                                ";
                            }
                        ?>
                        
                    </tbody>
                </table>
            </div>
        </div>    
    </div> 
</main>
<script>
  function del(id)
    {
        var r = confirm("Sind sie sicher, dass sie den Benutzer löschen wollen?");
        if (r == true) {
            document.getElementById('del'+id).click();
        } 
        else{
        }
    }
</script>
  </body>
</html>

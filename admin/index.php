<?php

session_start();
if($_SESSION["logedin"] === "yes")
{

}
else
{
    header("Location: login.php");
}
require('../phpscripts/connection.php');
    $con = new Connection();

if(isset($_POST['delete']))
{
    $con->sqlexec("UPDATE activity set deleted = 1 where id = " .$_POST['delete']);
    header("Location: index.php");
}
if(isset($_POST['submit']) || isset($_POST['update']))
{
    $church = $_SESSION['churchid'];
    $user = $_SESSION['userid'];

    $id = $_POST['id'];

    $title = $_POST['title'];
    $location = $_POST['location'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $participants = $_POST['participants'];
    $category = $_POST['category'];
    $body = $_POST['body'];

    if(isset($_POST['update']))
    {
        $con->sqlexec("UPDATE activity set title = '$title', body = '$body', date = '$date', time = '$time', location = '$location', participants = $participants, fcategoryID = $category, deleted = 0 where id = '$id'");
    }
    else{
        $con->sqlexec("INSERT INTO activity(id, title, body, date, time, location, participants, booked, fchurchId, fuserid, fcategoryID, deleted) VALUES (null,'$title','$body','$date','$time', '$location',$participants,0,$church,$user,$category,0)");

    }

    header("Location: index.php");
}

?>


<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>Revive Admin Seite</title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <img class="logo" src="../images/churches/iconbird.svg">
    <a class="navbar-brand" href="index.php">Revive Admin</a>
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
<h1>Hallo, <?php echo($_SESSION["username"]) ?></h1><br>
    <h4>Übersicht über alle deine Aktivitäten:</h4>
<div class="card">
  <div class="card-body">
  

    <table class="table">
        <thead>
            <tr>
            <th scope="col">Datum / Zeit</th>
            <th scope="col">Kategorie</th>
            <th scope="col">Titel</th>

            <th scope="col">Anmeldungen</th>

            <th scope="col">Aktionen</th>

        </tr>
        </thead>
        <tbody>
            <?php
                 $fuserid = $_SESSION['userid'];
                 $data = $con->sqlexec("Select * from revive.activity where date > NOW() AND fuserid = ". $fuserid ." AND deleted = 0 order by date asc"); 
                    
                $kats = ['', 'S.O.S', 'Outreach', 'Event', 'Equip'];


                 

                 $html = "";     
                 foreach($data as $key => $value)
                 {
                    $kat = $kats[$value['fcategoryID']];
                    $progressvalue = $value['booked'] / $value['participants'] * 100;
                    echo("
                    <tr '>
                        <td onclick='detail(". $value['id'] .")'>". $value['date'] ." / ".$value['time']."</td>
                        <td  onclick='detail(". $value['id'] .")'>". $kat ."</td>
                        <td  onclick='detail(". $value['id'] .")'>". $value['title'] ."</td>

                        <td  onclick='detail(". $value['id'] .")'>
                        <p class='percent'><b>". $value['booked'] . " / ". $value['participants'] . "</b></p>

                        <div class='progress'>
                        <div class='bar' style='width:". $progressvalue ."%'>
                            
                        </div>

                    </div></td>
                        <td>
                            <button type='button' onclick='edit(". $value['id'] .")' class='btn btn-light'>Bearbeiten</button>
                            <button type='button' onclick='del(". $value['id'] .")' class='btn btn-danger'>Löschen</button>
                            <form style='display: none' action='#' method='POST'>
                                <input type='submit' name='delete' id='del". $value['id'] ."' value='". $value['id'] ."'>
                            </form>
                            <form style='display: none' action='newActivity.php' method='POST'>
                                <input type='submit' name='update' id='edit". $value['id'] ."' value='". $value['id'] ."'>
                            </form>
                        </td>
                    </tr>
                    ");
                 }

            ?>



           
            
        </tbody>
    </table>
  </div>
</div>
   
</main>

<script>
    function detail(id)
    {
        window.open("detail.php?id="+id, "_self");
    }
    function del(id)
    {
        var r = confirm("Sind sie sicher, dass sie den Eintrag löschen wollen?");
        if (r == true) {
            document.getElementById('del'+id).click();
        } 
        else{
        }
    }

    function edit(id)
    {
        document.getElementById('edit'+id).click();
    }
</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  </body>
</html>

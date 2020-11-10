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

$id = $_GET['id'];
$fuserid = $_SESSION['userid'];
$data = $con->sqlexec("Select * from revive.activity where id = $id"); 

$kats = ['', 'S.O.S', 'Outreach', 'Event', 'Equip'];

if(isset($_POST['deleteRegistration']))
{
    $con->sqlexec("UPDATE registration set deleted = 1 where id = " .$_POST['deleteRegistration']);
}
    
foreach($data as $key => $value)
{
    $title = $value['title'];
    $location = $value['location'];
    $date = $value['date'];
    $time = $value['time'];
    $participants = $value['participants'];
    $booked = $value['booked'];

    $percent = $booked/$participants*100;


    $kat = $kats[$value['fcategoryID']];

    $body = $value['body'];

}

?>

<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>Detail</title>
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
<div class="container" >
  <div class="row">
    <div class="col-5">
        <div class="card" >
            <h5 class="card-header"><b><?php echo $title;?></b></h5>
            <div class="card-body">
                <table class="table ">
                    <tbody style="text-align: left;">
                        <tr>
                            <td><b>Datum</b></td>
                            <td><?php echo $date;?></td>
                        </tr>
                        <tr>
                            <td><b>Zeit</b></td>
                            <td><?php echo $time;?></td>
                        </tr>
                        <tr>
                            <td><b>Ort</b></td>
                            <td><?php echo $location;?></td>
                        </tr>
                    
                        <tr>
                            <td><b>Kategorie</b></td>
                            <td><?php echo $kat;?></td>
                        </tr>
                        <tr>
                            <td><b>Teilnehmer</b></td>
                            <td>
                                <p class='percent' style="text-align: center;"><b><?php echo $booked. " / ". $participants;?></b></p>
                                <div class='progress'>
                                    <div class='bar' <?php echo ("style='width: " .$booked . "%';"); ?>> </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Inhalt</b></td>
                            <td><?php echo $body;?></td>
                        </tr>
                    </tbody>
                </table>
                
                <?php
                    echo("
                    <button type='button' onclick='edit(". $value['id'] .")' class='btn btn-light'>Bearbeiten</button>
                <button type='button' onclick='del(". $value['id'] .")' class='btn btn-danger'>Löschen</button>
                    <form style='display: none' action='index.php' method='POST'>
                    <input type='submit' name='delete' id='del". $id ."' value='". $id ."'>
                </form>
                <form style='display: none' action='newActivity.php' method='POST'>
                    <input type='submit' name='update' id='edit". $id ."' value='". $id ."'>
                </form>
                    ");
                ?>
            </div>
            
        </div>    
    </div>
    <div class="col-7">
        <div class="card" >
            <h5 class="card-header"><b>Anmeldungen</h5>
            <div class="card-body">
            <table class="table ">
                    <thead style="text-align: left;">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Telefon</th>
                            <!-- <th scope="col">Aktion</th> -->
                        </tr>
                    </thead>
                    <tbody style="text-align: left;">
                        <?php
                            $counter = 0;
                            $data = $con->sqlexec("Select * from revive.registration where factivityID = $id && deleted = 0"); 
                            foreach($data as $key => $value)
                            {
                                $counter++;
                                echo "
                                <tr>
                                <td><b>".$counter."</b></td>
                                <td>".$value['name']."</td>
                                <td>".$value['phone']."</td>
                               
                            </tr>
                                ";
                            }
                        ?>
                        <!-- DELETE BUTTON -->
                        <!-- <td>
                                    <button type='button' onclick='delRegistration(". $value['id'] .")' class='btn btn-danger'>Löschen</button>
                                    <form style='display: none' action='#' method='POST'>
                                    <input type='submit' name='deleteRegistration' id='delRegistration".$value['name']."' value='".$value['name']."'>
                                </form>
                                </td> -->
                        
                    </tbody>
                </table>
            </div>
        </div>    
    </div> 
</div>

</main>

<script>
    function delRegistration(id)
    {
        var r = confirm("Sind sie sicher, dass sie den Eintrag löschen wollen?");
        if (r == true) {
            document.getElementById('delRegistration'+id).click();
        } 
    }
    function del(id)
    {
        var r = confirm("Sind sie sicher, dass sie den Eintrag löschen wollen?");
        if (r == true) {
            document.getElementById('del'+id).click();
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

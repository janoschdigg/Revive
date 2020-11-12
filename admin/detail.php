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

if(isset($_POST['deleteRegistrationID']))
{
    $con->sqlexec("UPDATE registration set deleted = 1 where id = " .$_POST['deleteRegistrationID']);

    $data = $con->sqlexec("Select * from revive.activity where id = " .$_POST['fActID']); 
    foreach($data as $key => $value)
    {
        $booked = $value['booked'];
        $booked = $booked -1;
        $con->sqlexec("UPDATE revive.activity set booked = $booked where id = " .$_POST['fActID']);

    }
    header("Location: #");
}

$id = $_GET['id'];
$fuserid = $_SESSION['userid'];
$data = $con->sqlexec("Select * from revive.activity where id = $id"); 

$kats = ['', 'S.O.S', 'Outreach', 'Event', 'Equip'];


    
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
    <?php require('head.php'); ?>

    <title>Detail</title>
  </head>
  <body>
  <?php require('navigation.php'); ?>

<main>
  <div class="row">
    <div class="col-sm-12 col-md-5 mb-2">
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
                                    <div class='bar' <?php echo ("style='width: " .$percent . "%';"); ?>> </div>
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
    <div class="col-sm-12  col-md-7">
        <div class="card" >
            <h5 class="card-header"><b>Anmeldungen</h5>
            <div class="card-body">
            <table class="table ">
                    <thead style="text-align: left;">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Telefon</th>
                            <th scope="col">Aktion</th>
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
                                <td>
                                    <button type='button' onclick='delRegistration(". $value['id'] .")' class='btn btn-danger'>Löschen</button>
                                    <form style='display: none' action='#' method='POST'>
                                        <input type='number' name='fActID' value='".$value['factivityID']."'>
                                        <input type='submit' name='deleteRegistrationID' id='delRegistration".$value['id']."' value='".$value['id']."'>
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

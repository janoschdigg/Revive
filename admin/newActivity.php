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

    <script src="//code.jquery.com/jquery.min.js"></script>

    
    <title>Neue Aktivität</title>
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
        <?php
            if(isset($_POST['update']))
            {
                $fuserid = $_SESSION['userid'];

                $upd = $_POST['update'];

                require('../phpscripts/connection.php');
                $con = new Connection();
                $data = $con->sqlexec("Select * from revive.activity where fuserid = ". $fuserid ." AND id = ".$upd." order by date asc"); 
                    
                foreach($data as $key => $value)
                {
                    $title = $value['title'];
                    $body = $value['body'];
                    $date = $value['date'];
                    $time = $value['time'];
                    $location = $value['location'];
                    $participants = $value['participants'];
                    $cat = $value['fcategoryID'];
                }

            }
        ?>
        <h2><?php if(isset($upd)){echo "Aktivität bearbeiten";} else {echo "Neue Aktivität erstellen";} ?></h2>
        <form action="index.php" method="POST">
            <div class="form-group">
                <label for="exampleFormControlInput1">Titel</label>
                <input name="title" <?php if(isset($upd)){echo "value='".$title."'";} ?> required type="text" class="form-control" placeholder="bsp. Fussball Sonntag Nachmittag">
            </div>
            <div class="form-group">
        <label for="exampleFormControlInput1">Datum</label>

        <input <?php if(isset($upd)){echo "value='".$date."'";} ?> class="form-control" id="date" name="date" placeholder="YYYY-MM-DD" type="text"/>
     </div>
            
            <div class="form-group">

                    <label for="exampleFormControlInput1">Zeit</label>
                    <input <?php if(isset($upd)){echo "value='".$time."'";} ?> name="time" required type="text" class="form-control" placeholder="bsp. 12:00 oder 12:00 - 14:00">
                </div>
           
            <div class="form-group">
                <label for="exampleFormControlInput1">Ort</label>
                <input <?php if(isset($upd)){echo "value='".$location."'";} ?> name="location" required type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">max. Teilnehmer</label>
                <input <?php if(isset($upd)){echo "value='".$participants."'";} ?> name="participants" required type="number" class="form-control" >
            </div>
            <div class="form-group">
                <label for="exampleFormControlSelect1">Kategorie</label>
                <select <?php if(isset($upd)){echo "value='".$cat."'";} ?> name="category" class="form-control" id="exampleFormControlSelect1">
                    <option value="1">S.O.S</option>
                    <option value="2">Outreach</option>
                    <option value="3">Event</option>
                    <option value="4">Equip</option>
                </select>
            </div>
           
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Beschreibung</label>
                <textarea  name="body" required class="form-control" rows="4"><?php if(isset($upd)){echo $body;} ?></textarea>
            </div>
            <input style="display: none;"  name="id" type="number" <?php if(isset($upd)){echo "value='$upd'";} ?> class="form-control" >
            <div class="form-group">
                <input type="submit" <?php if(isset($upd)){echo "value='Änderungen Speichern' name='update'";} else {echo "value='Speichern' name='submit'";} ?> class="form-control" >
            </div>

        </form>
    </main>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>

  </body>
</html>

<!-- Include Date Range Picker -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script>
	$(document).ready(function(){
		var date_input=$('input[name="date"]'); //our date input has the name "date"
		var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
		date_input.datepicker({
			format: 'yyyy-mm-dd',
			container: container,
			todayHighlight: true,
			autoclose: true,
		})
	})
</script>
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
    <?php require('head.php'); ?>
    
    <title>Neue Aktivität</title>
  </head>
  <body>
    <?php require('navigation.php'); ?>
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
        <form class="activityForm" action="index.php" method="POST">
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
                <select name="category" class="form-control" id="exampleFormControlSelect1">
                    <option <?php if(isset($upd) && $cat == "1"){echo "selected";} ?> value="1">S.O.S</option>
                    <option <?php if(isset($upd) && $cat == "2"){echo "selected";} ?> value="2">Outreach</option>
                    <option <?php if(isset($upd) && $cat == "3"){echo "selected";} ?> value="3">Event</option>
                    <option <?php if(isset($upd) && $cat == "4"){echo "selected";} ?> value="4">Equip</option>
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
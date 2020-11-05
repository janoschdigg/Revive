
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

$type = $_GET['type'];

if(isset($_GET['id']))
{
    $id = $_GET['id'];
}
if($type == 'registration')
{
   $result = $con->sqlexec("Select * from revive.activity where id = " . $id);
   foreach($result as $key => $value)
   {
      $booked = $value['booked'];
   }
   $booked = $booked + 1;

   $con->sqlexec("INSERT INTO registration(id, factivityID, name, phone) VALUES (null,'$id','".$_GET['name']."','".$_GET['phone'].", 0');");
   $con->sqlexec("UPDATE activity set booked = $booked where id = '$id'");

}





?>



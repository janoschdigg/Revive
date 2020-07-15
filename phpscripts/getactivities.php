
<?php
    require('../phpscripts/connection.php');
    $con = new Connection();
    echo json_encode($con->sqlexec("Select * from revive.activity"))
    // print_r($con->sqlexec("Select * from revive.activity")) ;
?>

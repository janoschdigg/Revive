
<?php

    require('../phpscripts/connection.php');
    $con = new Connection();
    $type = $_GET['type'];

    if($type == 'activity')
    {
        echo json_encode($con->sqlexec("Select * from revive.activity"));
    }

    if($type == 'church')
    {
        echo json_encode($con->sqlexec("Select * from revive.church"));
    }
?>
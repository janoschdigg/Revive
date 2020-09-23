
<?php

require('../phpscripts/connection.php');
$con = new Connection();
$type = $_GET['type'];

if(isset($_GET['id']))
{
    $id = $_GET['id'];
}
if($type == 'activity')
{
    echo json_encode($con->sqlexec("Select * from revive.activity order by date asc"));
}
if($type == 'church')
{
    echo json_encode(mb_convert_encoding($con->sqlexec("Select * from revive.church"), 'UTF-8', 'UTF-8'));
}
if($type == 'detail' && isset($_GET['id']))
{
    echo json_encode($con->sqlexec("Select * from revive.activity where id = " . $id));
}
if($type == 'user' && isset($_GET['id']))
{
    echo json_encode($con->sqlexec("Select * from revive.user where id = " . $id));
}

?>


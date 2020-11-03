
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
	$result = $con->sqlexec("Select * from revive.activity where date > NOW() order by date asc");
   echo json_encode($result , JSON_INVALID_UTF8_IGNORE | JSON_PARTIAL_OUTPUT_ON_ERROR);

}
if($type == 'church')
{
	$result = $con->sqlexec("Select * from revive.church");
   echo json_encode($result , JSON_INVALID_UTF8_IGNORE | JSON_PARTIAL_OUTPUT_ON_ERROR);
}
if($type == 'detail' && isset($_GET['id']))
{
	$result = $con->sqlexec("Select * from revive.activity where id = " . $id);
   echo json_encode($result , JSON_INVALID_UTF8_IGNORE | JSON_PARTIAL_OUTPUT_ON_ERROR);
}
if($type == 'user' && isset($_GET['id']))
{
	$result = $con->sqlexec("Select * from revive.user where id = " . $id);
   echo json_encode($result , JSON_INVALID_UTF8_IGNORE | JSON_PARTIAL_OUTPUT_ON_ERROR);
}

?>



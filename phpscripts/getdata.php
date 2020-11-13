
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
	$result = $con->sqlexec("Select * from revive.activity where date > NOW() AND deleted = 0 order by date asc");
   echo json_encode($result , JSON_INVALID_UTF8_IGNORE | JSON_PARTIAL_OUTPUT_ON_ERROR);

}
if($type == 'church')
{
	$result = $con->sqlexec("Select * from revive.church");
   echo json_encode($result , JSON_INVALID_UTF8_IGNORE | JSON_PARTIAL_OUTPUT_ON_ERROR);
}
if($type == 'detail' && isset($_GET['id']))
{
	$result = $con->sqlexec("Select act.id, title, date, body, time, location, participants, booked, act.fchurchId, fuserid, fcategoryID, act.deleted, ch.name, fAdminId, logo, user.name as username, user.mail from revive.activity as act INNER Join revive.church as ch ON act.fchurchID = ch.id INNER JOIN user ON act.fuserid = user.id where act.id =" . $id);
   echo json_encode($result , JSON_INVALID_UTF8_IGNORE | JSON_PARTIAL_OUTPUT_ON_ERROR);
}
if($type == 'user' && isset($_GET['id']))
{
	$result = $con->sqlexec("Select * from revive.user where id = " . $id);
   echo json_encode($result , JSON_INVALID_UTF8_IGNORE | JSON_PARTIAL_OUTPUT_ON_ERROR);
}

?>




<?php

session_start();


require('../phpscripts/connection.php');
$con = new Connection();

$type = $_GET['type'];

if(isset($_GET['id']))
{
    $id = $_GET['id'];
    if($type == 'registration')
    {
        if(isset($_GET['name']) && $_GET['name'] != "" && isset($_GET['phone']) && $_GET['phone'] != "")
        {
            $result = $con->sqlexec("Select * from revive.activity where id = " . $id);
            foreach($result as $key => $value)
            {
                $booked = $value['booked'];
            }
            $booked = $booked + 1;
    
            $con->sqlexec("INSERT INTO registration(id, factivityID, name, phone, deleted) VALUES (null,$id,'".$_GET['name']."','".$_GET['phone']."', 0);");
            $con->sqlexec("UPDATE activity set booked = $booked where id = '$id'");

            echo "true";
        }
        else
        {
            echo "false";
        }
    
    }
    else
    {
        echo "false";
    }
}
else if(isset($_POST['feedback']))
{
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $feedback = $_POST['feedback'];
    $waiver = $_POST['waiver'];

    $body = "
    <div>
        <p><b>Name: </b>$name</p>
        <p><b>Nummer: </b>$phone</p>
        <p><b>Feedback: </b>$feedback</p>
        <p><b>Will kontaktiert werden: </b>$waiver</p>
    </div>
";

$betreff = "Neues Feedback von Revive";
$header  = "MIME-Version: 1.0\r\n";
$header .= "Content-type: text/html; charset=utf-8\r\n";
$header .= "From: feedback@revive.ch\r\n";
$header .= "X-Mailer: PHP ". phpversion();

mail("janosch.diggelmann@gmail.com",$betreff,$body,$header);
echo true;
}
else if(isset($_POST['username']) && $type === "login")
{
    $user = $_POST['username'];
    $pw = $_POST['password'];
    $result = $con->sqlexec("Select * from revive.user where username = '" . $user . "' AND password='". $pw ."'");
    echo json_encode($result , JSON_INVALID_UTF8_IGNORE | JSON_PARTIAL_OUTPUT_ON_ERROR);
}
else
{
    echo "false";
}




?>



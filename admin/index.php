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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revive Admin Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<body>
    <nav>
        <img src="../images/churches/iconbird.svg" alt="Logo" class="logo">
        <h2>REVIVE Admin Page</h2> 
        <a href="login.php?logout=true" style="float: right; margin-top:60px; margin-right: 20px; color: white;">Log Out</a>
</nav>
    <main>
        <ul>
            <a href="newActivity.php"><li class="card"><h3>Aktivität erfassen</h3>Eine neue Aktivität hinzufügen.</li></a>
            <a href="overview.php"><li class="card"><h3>Meine Aktivitäten</h3>Übersicht über meine erfassten Aktivitäten</li></a>
        </ul>
    </main>
    </body>
</body>
</html>
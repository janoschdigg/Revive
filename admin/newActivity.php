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
    <title>Neue Aktivität</title>
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
        <div class="container">
            <h1>Neue Aktivität erfassen</h1>
            <form action="overview.php" method="POST">
                <input type="text" placeholder="Titel"><br>
                <textarea placeholder="Beschreibung">

                </textarea><br>
                <input type="date" placeholder="Datum"><br>
                <input type="text" placeholder="Zeit z.B. 12:00"><br>
                <input type="number" placeholder="Maximale Personen"><br>
                <input type="submit" value="Speichern">
            </form>

        </div>
    </main>
</body>
</body>
</html>
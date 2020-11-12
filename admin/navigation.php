<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
    <a href="index.php">  
        <img class="logo d-none d-md-block d-lg-block" src="../images/churches/iconbird.svg">
    </a>
    <a class="navbar-brand" href="index.php">Revive Admin</a>
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="newActivity.php">Neue Aktivität</a>
      </li>

     <?php
        if($_SESSION["isadmin"] === "1")
        {
            echo "
            <li class='nav-item dropdown'>
            <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
              Admin
            </a>
            <div class='dropdown-menu' aria-labelledby='navbarDropdown'>
              <a class='dropdown-item' href='user.php'>Benutzer</a>
              <div class='dropdown-divider'></div>
              <a class='dropdown-item' href='delActivities.php'>Gelöschte Ereignisse</a>
              <a class='dropdown-item' href='delRegistration.php'>Gelöschte Anmeldungen</a>
            </div>
          </li>
            ";
        }
     ?>

      <li class="nav-item">
        <a class="nav-link " href="login.php?logout=true">Log Out</a>
      </li>
    </ul>
  </div>
</nav>
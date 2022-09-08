<?php
session_start();
if(!isset($_SESSION["username"])){
  header("location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="navbar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://use.fontawesome.com/d9f067883d.js"></script>
  </head>
    <!-- navbar -->
    <nav class="navbar navbar-expand-sm navbar-light bg-dark bg-gradient">
    <div class="container-fluid">
    <img src="logo.jpg" alt="" width="140" height="100" style="border-radius:50%; margin-right:5px;">
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <?php
        $nameNick = explode(" ", $_SESSION["username"]);
        if(isset($_SESSION["username"])){
          echo "<span style='overflow: hidden; white-space: nowrap;color:white;'>Hello, {$nameNick[0]}</span>";
        }
        echo"
      <div class=\"navbar-nav\" style=\"margin-left: 750px !important;\">
        <a class=\"nav-link\" style=\"color: white !important; padding: 15px !important;\" active\" aria-current=\"page\" href=\"home.php\">Home</a>
        <a class=\"nav-link\" style=\"color: white !important; padding: 15px !important;\"  href=\"menu.php\">Rides</a>
        <a class=\"nav-link\" style=\"color: white !important; padding: 15px !important;\"  href=\"#\">About Us</a>
        <a class=\"nav-link\" style=\"color: white !important; padding: 15px !important;\"  href=\"orders.php\">$nameNick[0]'s Rides</a>";
        if(isset($_SESSION["username"])){
          echo "<a class='nav-link' style=\"color: white !important; padding: 15px !important;\" href='../includes/logout.inc.php'>Logout</a>";
        }
        ?>
      </div>
    </div>
    </div>
    </nav>
</html>

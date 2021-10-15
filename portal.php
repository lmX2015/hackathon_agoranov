<?php
include("security.php");
?>

<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title></title>
  <meta name="description" content="">


  <!-- Place favicon.ico in the root directory -->

  <link rel="stylesheet" type="text/css" href="css/bootstrap/bootstrap.min.css" media="screen" />
  <link rel="stylesheet" type="text/css" href="css/main.css" media="screen" />

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <!--<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />-->

<!--<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>-->
  <script src="js/html5.js"></script>

  <title>Skynov - Home</title>

  <meta name="theme-color" content="#fafafa">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Skynov</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="#">Home
            <span class="visually-hidden">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link"  href="password_change.php">Change Password</a>
           </li>
        <li class="nav-item">
          <a class="nav-link"  href="user_extra.php">New User</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php" onclick="return confirm('Are you sure you want to leave?');">Logout</a>
        </li>

      </ul>
    </div>
  </div>
</nav>

<div class="main">
<h2> Welcome <?php if(isset($_SESSION["login"])){echo ucwords($_SESSION["login"]);}?>

<h5>Your secret is "<?php if(isset($_SESSION["secret"])){echo ucwords($_SESSION["secret"]);}?>". Keep it safe ! </h5>
</div>



<script src="js/vendor/modernizr-3.11.2.min.js"></script>
  <script src="js/plugins.js"></script>
  <script src="js/main.js"></script>

  </body>

</html>

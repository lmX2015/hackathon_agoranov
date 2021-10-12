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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <!--<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />-->

<!--<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>-->
  <script src="js/html5.js"></script>

  <title>bWAPP - Portal</title>

  <meta name="theme-color" content="#fafafa">
</head>

<body>

<header>

  <h1>Skynov</h1>

  <h2>An extremely unsecure web document storage !</h2>

</header>

<div id="menu">

  <table>

    <tr>

      <td><font color="#ffb717">Bugs</font></td>
      <td><a href="password_change.php">Change Password</a></td>
      <td><a href="user_extra.php">Create User</a></td>
      <td><a href="logout.php" onclick="return confirm('Are you sure you want to leave?');">Logout</a></td>
      <td><font color="red">Welcome <?php if(isset($_SESSION["login"])){echo ucwords($_SESSION["login"]);}?></font></td>

    </tr>

  </table>

</div>

<div id="main">

  <h1>Portal</h1>

  <p>Description</p>





  </form>

</div>



<script src="js/vendor/modernizr-3.11.2.min.js"></script>
  <script src="js/plugins.js"></script>
  <script src="js/main.js"></script>

  </body>

</html>

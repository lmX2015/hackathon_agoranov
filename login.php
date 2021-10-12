<?php


include("connect_i.php");
include("admin/settings.php");

session_start();

$message = "";

if(isset($_POST["form"]))
{

    $login = $_POST["login"];
    $login = mysqli_real_escape_string($link, $login);

    $password = $_POST["password"];
    $password = mysqli_real_escape_string($link, $password);
    $password = hash("sha1", $password, false);

    $sql = "SELECT * FROM users WHERE login = '" . $login;
    $sql.= "' AND BINARY password = '" . $password . "'";
    // Checks if the user is activated
    $sql.= " AND activated = 1";

    // Debugging
    // echo $sql;

    $recordset = $link->query($sql);

    if(!$recordset)
    {

        die("Error: " . $link->error);

    }

    else
    {

        $row = $recordset->fetch_object();

        // Debugging
        // print_r($row);

        if($row)
        {

            session_regenerate_id(true);

            $token = sha1(uniqid(mt_rand(0,100000)));

            $_SESSION["login"] = $row->login;
            $_SESSION["admin"] = $row->admin;
            $_SESSION["token"] = $token;
            $_SESSION["amount"] = 1000;


            setcookie("security_level", "0", time()+60*60*24*365, "/", "", false, false);


            header("Location: portal.php");

            exit;

        }

        else
        {

        $message = "<font color=\"red\">Invalid credentials or user not activated!</font>";

        }

    }

}

?>
<!DOCTYPE html>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<link rel="stylesheet" type="text/css" href="css/bootstrap/bootstrap.min.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/main.css" media="screen" />
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />

<!--<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>-->
<script src="js/html5.js"></script>

<title>Skynov - Login</title>

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
          <a class="nav-link active" href="#">Login
            <span class="visually-hidden">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link"  href="user_extra.php">New User</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="info.php">Info</a>
        </li>

      </ul>
    </div>
  </div>
</nav>

<div class="main">
<h2>Skynov, an extremely unsecure application !</h1>
<div>
<p>Enter your credentials.</p>

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST">
        <fieldset>
        <div class="form-group">
          <label for="login" class="form-label mt-4">Login:</label>
          <input type="email" class="form-control" id="login" name="login" placeholder="Enter username">
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1" class="form-label mt-4">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>

        <button class="btn btn-primary" type="submit" name="form" value="submit">Login</button>
        </fieldset>
    </form>

    <br />
    <?php

    echo $message;

    $link->close();

    ?>

</div>
</div>







</body>

</html>

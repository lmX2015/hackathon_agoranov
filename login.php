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

<!--<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Architects+Daughter">-->
<link rel="stylesheet" type="text/css" href="stylesheets/stylesheet.css" media="screen" />
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />

<!--<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>-->
<script src="js/html5.js"></script>

<title>Skynov - Login</title>

</head>

<body>

<header>

<h1>Skynov</h1>

<h2>An extremely unsecure web document storage !</h2>

</header>

<div id="menu">

    <table>

        <tr>

            <td><font color="#ffb717">Login</font></td>
            <td><a href="user_new.php">New User</a></td>
            <td><a href="info.php">Info</a></td>

        </tr>

    </table>

</div>

<div id="main">

    <h1>Login</h1>

    <p>Enter your credentials.</p>

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST">

        <p><label for="login">Login:</label><br />
        <input type="text" id="login" name="login" size="20" autocomplete="off"></p>

        <p><label for="password">Password:</label><br />
        <input type="password" id="password" name="password" size="20" autocomplete="off"></p>


        </p>

        <button type="submit" name="form" value="submit">Login</button>

    </form>

    <br />
    <?php

    echo $message;

    $link->close();

    ?>

</div>


</body>

</html>

<?php

include("security.php");
include("functions_external.php");
include("connect_i.php");
include("admin/settings.php");

$message = "";

if(isset($_REQUEST["action"]))
{

    $login = $_REQUEST["login"];
    $password = $_REQUEST["password"];
    $password_conf = $_REQUEST["password_conf"];
    $email = $_REQUEST["email"];
    $secret = $_REQUEST["secret"];
    $mail_activation = isset($_POST["mail_activation"]) ? 1 : 0;

    if($login == "" or $email == "" or $password == "" or $secret == "")
    {

        $message = "<font color=\"red\">Please enter all the fields!</font>";

    }

    else
    {

        /*

        /^[a-z\d_]{2,20}$/i
        ||||  | |||     |||
        ||||  | |||     ||i : case insensitive
        ||||  | |||     |/ : end of regex
        ||||  | |||     $ : end of text
        ||||  | ||{2,20} : repeated 2 to 20 times
        ||||  | |] : end character group
        ||||  | _ : underscore
        ||||  \d : any digit
        |||a-z: 'a' through 'z'
        ||[ : start character group
        |^ : beginning of text
        / : regex start

         */

        if(preg_match("/^[a-z\d_]{2,20}$/i", $login) == false)
        {

            $message = "<font color=\"red\">Please choose a valid login name!</font>";

        }

        else
        {

            if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            {

                $message = "<font color=\"red\">Please enter a valid e-mail address!</font>";

            }

            else
            {

                if($password != $password_conf)
                {

                    $message = "<font color=\"red\">The passwords don't match!</font>";

                }

                else
                {

                    // Input validations
                    $login = mysqli_real_escape_string($link, $login);
                    $login = htmlspecialchars($login, ENT_QUOTES, "UTF-8");

                    $password = mysqli_real_escape_string($link, $password);
                    $password = hash("sha1", $password, false);

                    $email = mysqli_real_escape_string($link, $email);
                    $email = htmlspecialchars($email, ENT_QUOTES, "UTF-8");

                    $secret = mysqli_real_escape_string($link, $secret);
                    $secret = htmlspecialchars($secret, ENT_QUOTES, "UTF-8");

                    $sql = "SELECT * FROM users WHERE login = '" . $login . "' OR email = '" . $email . "'";

                    // Debugging
                    // echo $sql;

                    $recordset = $link->query($sql);

                    if(!$recordset)
                    {

                        die("Error: " . $link->error);

                    }

                    // Debugging
                    // echo "<br />Affected rows: ";
                    // printf($link->affected_rows);

                    $row = $recordset->fetch_object();

                    // If the user is not present
                    if(!$row)
                    {

                        // Debugging
                        // echo "<br />Row: ";
                        // print_r($row);

                        if($mail_activation == false)
                        {

                            $sql = "INSERT INTO users (login, password, email, secret, activated) VALUES ('" . $login . "','" . $password . "','" . $email .  "','" . $secret . "',1)";

                            // Debugging
                            // echo $sql;

                            $recordset = $link->query($sql);

                            if(!$recordset)
                            {

                                die("Error: " . $link->error);

                            }

                            // Debugging
                            // echo "<br />Affected rows: ";
                            // printf($link->affected_rows);

                            $message = "<font color=\"green\">User successfully created!</font>";

                        }

                    }

                    else
                    {

                        $message = "<font color=\"red\">The login or e-mail already exists!</font>";

                    }

                }

            }

        }

    }

}

?>
<!DOCTYPE html>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!--<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Architects+Daughter">-->
<link rel="stylesheet" type="text/css" href="css/stylesheet.css" media="screen" />
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />

<!--<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>-->
<script src="js/html5.js"></script>

<title>Skynov - Create User</title>

</head>

<body>

<header>
 <h1>Skynov</h1>

  <h2>An extremely unsecure web document storage !</h2>


</header>

<div id="menu">

    <table>

        <tr>

            <td><a href="portal.php">Home</a></td>
            <td><a href="password_change.php">Change Password</a></td>
            <td><font color="#ffb717">Create User</font></td>
            <td><a href="logout.php" onclick="return confirm('Are you sure you want to leave?');">Logout</a></td>
            <td><font color="red">Welcome <?php if(isset($_SESSION["login"])){echo ucwords($_SESSION["login"]);}?></font></td>

        </tr>

    </table>

</div>

<div id="main">

    <h1>Create User</h1>

    <p>Create an extra user.</p>

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST">

        <table>

        <tr><td>

        <p><label for="login">Login:</label><br />
        <input type="text" id="login" name="login"></p>

        </td>

        <td width="5"></td>

        <td>

        <p><label for="email">E-mail:</label><br />
        <input type="text" id="email" name="email" size="30"></p>

        </td></tr>

        <tr><td>

        <p><label for="password">Password:</label><br />
        <input type="password" id="password" name="password"></p>

        </td>

        <td width="25"></td>

        <td>

        <p><label for="password_conf">Re-type password:</label><br />
        <input type="password" id="password_conf" name="password_conf"></p>

        </td></tr>

        <tr><td colspan="3">

        <p><label for="secret">Secret:</label><br />
        <input type="text" id="secret" name="secret" size="40"></p>

        </td></tr>

        <tr><td>


        </td></tr>

        </table>

        <button type="submit" name="action" value="create">Create</button>

    </form>

    <br />
    <?php

    echo $message;

    $link->close();

    ?>

</div>


</body>

</html>

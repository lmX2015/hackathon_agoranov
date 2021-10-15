<?php

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
    $mail_activation = 0;

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

 <link rel="stylesheet" type="text/css" href="css/bootstrap/bootstrap.min.css" media="screen" />
 <link rel="stylesheet" type="text/css" href="css/main.css" media="screen" />

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
   <!--<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />-->

 <!--<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>-->
   <script src="js/html5.js"></script>

   <title>Skynov - Sign Up</title>

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
           <a class="nav-link" href="portal.php">Home
           </a>
         </li>
         <li class="nav-item">
           <a class="nav-link active"  href="#">New User</a>
             <span class="visually-hidden">(current)</span>

         </li>
          <?php if(isset($_SESSION["login"])){echo <li class="nav-item">
           <a class="nav-link" href="logout.php" onclick="return confirm('Are you sure you want to leave?');">Logout</a>
         </li>}
         ?>

       </ul>
     </div>
   </div>
 </nav>



<div id="main">

    <h2>Sign Up</h2>

    <div class="form-wrapper">

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST">
      <fieldset>
        <div class="form-group">
          <label for="login" class="form-label mt-4">Login</label>
           <input type="text" class="form-control" id="login" name="login" placeholder="Enter username">
        </div>
        <div class="form-group">
          <label for="email" class="form-label mt-4">Email address</label>
          <input type="text" class="form-control" id="email" name="email"   placeholder="Enter email">
        </div>
        <div class="form-group">
          <label for="password" class="form-label mt-4">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        </div>
         <div class="form-group">
            <label for="password_conf" class="form-label mt-4">Re-type password:</label>
            <input type="password" class="form-control" id="password_conf"  name="password_conf" placeholder="Confirm password">
        </div>
        <div class="form-group">
           <label for="login" class="form-label mt-4">Secret</label>
           <input type="text"  class="form-control"  id="secret" name="secret" placeholder="Enter your secret">
         </div>

        </fieldset>
        <button type="submit" class="btn btn-primary" name="action" value="create">Create</button>
      </fieldset>
    </form>
    </div>

    <br />
    <?php

    echo $message;

    $link->close();

    ?>

</div>


</body>

</html>

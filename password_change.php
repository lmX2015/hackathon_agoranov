<?php

include("security.php");
include("connect_i.php");

$message = "";

if(isset($_REQUEST["action"]))
{

    $password_new = $_REQUEST["password_new"];
    $password_conf = $_REQUEST["password_conf"];

    if($password_new == "")
    {

        $message = "<font color=\"red\">Please enter a new password...</font>";

    }

    else
    {

        if($password_new != $password_conf)
        {

            $message = "<font color=\"red\">The passwords don't match!</font>";

        }

        else
        {

            $login = $_SESSION["login"];

            $password_new = mysqli_real_escape_string($link, $password_new);
            $password_new = hash("sha1", $password_new, false);

            $password_curr = $_REQUEST["password_curr"];
            $password_curr = mysqli_real_escape_string($link, $password_curr);
            $password_curr = hash("sha1", $password_curr, false);

            $sql = "SELECT password FROM users WHERE login = '" . $login . "' AND password = '" . $password_curr . "'";

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

            if($row)
            {

                // Debugging
                // echo "<br />Row: ";
                // print_r($row);

                $sql = "UPDATE users SET password = '" . $password_new . "' WHERE login = '" . $login . "'";

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

                $message = "<font color=\"green\">The password has been changed!</font>";

            }

            else
            {

                $message = "<font color=\"red\">The current password is not valid!</font>";

            }

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
   <!--<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />-->

 <!--<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>-->
   <script src="js/html5.js"></script>


<title>Skynov - Change Password</title>

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
           <a class="nav-link active"  href="#">Change Password</a>
             <span class="visually-hidden">(current)</span>
            </li>
         <li class="nav-item">
           <a class="nav-link "  href="user_extra.php">Create User</a>

         </li>
         <li class="nav-item">
           <a class="nav-link" href="logout.php" onclick="return confirm('Are you sure you want to leave?');">Logout</a>
         </li>

       </ul>
     </div>
   </div>
 </nav>



<div id="main">

    <h2>Change Password</h2>

    <div class="form-wrapper">
    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST">
      <fieldset>
        <div class="form-group">
          <label for="password" class="form-label mt-4">Current password:</label>
          <input type="password" class="form-control" id="password_conf" name="password_curr" placeholder="Password">
        </div>
         <div class="form-group">
                    <label for="password_conf" class="form-label mt-4">New password:</label>
                    <input type="password" class="form-control" id="password_new"  name="password_new" placeholder="Enter new password">
                </div>

         <div class="form-group">
            <label for="password_conf" class="form-label mt-4">Re-type new password:</label>
            <input type="password" class="form-control" id="password_conf"  name="password_conf" placeholder="Confirm password">
        </div>

        </fieldset>
        <button type="submit" class="btn btn-primary" name="action" value="change">Change</button>
      </fieldset>
    </form>
    </div>

    </br >
    <?php

    echo $message;

    $link->close();

    ?>
</div>



</body>

</html>

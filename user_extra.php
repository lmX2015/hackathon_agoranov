<?php

include("security.php");
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
           <a class="nav-link" href="portal.php">Home
           </a>
         </li>
         <li class="nav-item">
           <a class="nav-link"  href="password_change.php">Change Password</a>
            </li>
         <li class="nav-item">
           <a class="nav-link active"  href="#">Create User</a>
             <span class="visually-hidden">(current)</span>

         </li>
         <li class="nav-item">
           <a class="nav-link" href="logout.php" onclick="return confirm('Are you sure you want to leave?');">Logout</a>
         </li>

       </ul>
     </div>
   </div>
 </nav>

 <div class="main">
 <h2>Skynov, an extremely unsecure application !</h1>
 <p>
    Welcome <?php if(isset($_SESSION["login"])){echo ucwords($_SESSION["login"]);}?>
 </p>

</div>

<div id="main">

    <h1>Create User</h1>

    <p>Create an extra user.</p>

    <form>
      <fieldset>
        <legend>Legend</legend>
        <div class="form-group row">
          <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
          <div class="col-sm-10">
            <input type="text" readonly="" class="form-control-plaintext" id="staticEmail" value="email@example.com">
          </div>
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1" class="form-label mt-4">Email address</label>
          <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
          <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1" class="form-label mt-4">Password</label>
          <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
        </div>
        <div class="form-group">
          <label for="exampleSelect1" class="form-label mt-4">Example select</label>
          <select class="form-select" id="exampleSelect1">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
          </select>
        </div>
        <div class="form-group">
          <label for="exampleSelect2" class="form-label mt-4">Example multiple select</label>
          <select multiple="" class="form-select" id="exampleSelect2">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
          </select>
        </div>
        <div class="form-group">
          <label for="exampleTextarea" class="form-label mt-4">Example textarea</label>
          <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
        </div>
        <div class="form-group">
          <label for="formFile" class="form-label mt-4">Default file input example</label>
          <input class="form-control" type="file" id="formFile">
        </div>
        <fieldset class="form-group">
          <legend class="mt-4">Radio buttons</legend>
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
              Option one is this and that—be sure to include why it's great
            </label>
          </div>
          <div class="form-check">
            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios2" value="option2">
              Option two can be something else and selecting it will deselect option one
            </label>
          </div>
          <div class="form-check disabled">
            <label class="form-check-label">
              <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios3" value="option3" disabled="">
              Option three is disabled
            </label>
          </div>
        </fieldset>
        <fieldset class="form-group">
          <legend class="mt-4">Checkboxes</legend>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
              Default checkbox
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked="">
            <label class="form-check-label" for="flexCheckChecked">
              Checked checkbox
            </label>
          </div>
        </fieldset>
        <fieldset>
          <legend class="mt-4">Switches</legend>
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
            <label class="form-check-label" for="flexSwitchCheckDefault">Default switch checkbox input</label>
          </div>
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked="">
            <label class="form-check-label" for="flexSwitchCheckChecked">Checked switch checkbox input</label>
          </div>
        </fieldset>
        <fieldset class="form-group">
          <legend class="mt-4">Ranges</legend>
            <label for="customRange1" class="form-label">Example range</label>
            <input type="range" class="form-range" id="customRange1">
            <label for="disabledRange" class="form-label">Disabled range</label>
            <input type="range" class="form-range" id="disabledRange" disabled="">
            <label for="customRange3" class="form-label">Example range</label>
            <input type="range" class="form-range" min="0" max="5" step="0.5" id="customRange3">
        </fieldset>
        <button type="submit" class="btn btn-primary">Submit</button>
      </fieldset>
    </form>

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

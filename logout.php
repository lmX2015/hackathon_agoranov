<?php


include("security.php");

// Destroys the session
$_SESSION = array();
session_destroy();

// Deletes the cookies
setcookie("admin", "", time()-3600, "/", "", false, false);

header("Location: login.php");

?>

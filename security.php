<?php

include("admin/settings.php");

session_start();

if(!(isset($_SESSION["login"]) && $_SESSION["login"]))
{

    header("Location: login.php");
    exit;

}

?>

<?php
require_once("requires/functions.php");

// end the current session and log the user out
$_SESSION["currentUser"] = "";
$_SESSION["currentUser"] = "";
session_destroy();
redirectTo("login.php");
?>
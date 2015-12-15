<?php
ob_start();
session_start();
header('Cache-Control: max-age=900');

require_once("database.php");

// check to see if the user is logged in from the current session
function isLoggedIn() {
    return isset($_SESSION["currentUser"]) && !empty($_SESSION["currentUser"]);
}

// redirect the user to the given locattion
function redirectTo($location = NULL) {
  if ($location != NULL) {
    header("Location: {$location}");
    exit;
  }
}

// close the current database connection
function closeConnection() {
    global $database;
    $database->closeConnection();
}

// escape the user's input value
function escapeValue($input) {
    global $database;
    return $database->escapeValue($input);
}
?>


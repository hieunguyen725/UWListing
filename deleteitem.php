<?php
require_once("requires/functions.php");
require_once("requires/datasource.php");

// if the user is not logged in, redirect them to the
// log in page, else delete the item
if (!isLoggedIn()) {
    redirectTo("login.php");
} else {
    if (isset($_POST["delete"])) {
        $itemID = $_POST["itemID"];
        $username = $_SESSION["currentUser"];
        DataSource::deleteItem($itemID, $username);
    } 
    redirectTo("myitems.php");
}
closeConnection();
?>
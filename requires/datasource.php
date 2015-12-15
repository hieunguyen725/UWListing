<?php

require_once("database.php");

// This is a class that will represent as a datasource for the user
// by allowing them to manipulate the current database.
class DataSource {
    
    // return all the users in the current database
    public static function getAllUser() {
        global $database;
        $query = "SELECT * FROM user;";
        return $database->query($query);
    }

    // return the user with the matching query selection
    public static function getUser($selection) {
        global $database;
        $query = "SELECT * FROM user ";
        $query .= "WHERE " . $selection . " ;";
        return $database->query($query);
    }

    // return the reviews for the given username
    public static function getUserReviews($username) {
        global $database;
        $query = "SELECT reviewDescription FROM review ";
        $query .= "NATURAL JOIN user ";
        $query .= "WHERE username = '{$username}';";
        return $database->query($query);
    }

    // create a new review for the given user
    public static function createUserReview($username, $review) {
        global $database;
        $query = "INSERT INTO review (username, reviewDescription) ";
        $query .= "VALUES ('{$username}', '{$review}');";
        return $database->query($query);
    }

    // create a new user for the system
    public static function createUser($username, $password, $firstName, 
            $lastName, $emailAddress, $phoneNumber) {
        global $database;
        $query = "INSERT INTO user ";
        $query .= "VALUES ('{$username}', '{$password}', ";
        $query .= "'{$firstName}', '{$lastName}', '{$emailAddress}', ";
        $query .= "'{$phoneNumber}');";
        return $database->query($query);
    }
    
    // update the user profile information with the given username and
    // its information
    public static function updateUser($username, $firstName, $lastName, 
            $emailAddress, $phoneNumber) {
        global $database;
        $query = "UPDATE user ";
        $query .= "SET firstName = '{$firstName}', ";
        $query .= "lastName = '{$lastName}', ";
        $query .= "emailAddress = '{$emailAddress}', ";
        $query .= "phoneNumber = '{$phoneNumber}' ";
        $query .= "WHERE username = '{$username}';";
        return $database->query($query);       
    }

    // return all the items in the database
    public static function getAllItems() {
        global $database;
        $query = "SELECT * FROM item NATURAL JOIN user_item NATURAL JOIN user;";
        return $database->query($query);
    }
    
    // get the information of the item given the item ID
    public static function getItem($itemID) {
        global $database;
        $query = "SELECT * FROM item WHERE itemID = {$itemID};";
        return $database->query($query);
    }

    // get the items for the given username
    public static function getUserItems($username) {
        global $database;
        $query = "SELECT * FROM item ";
        $query .= "NATURAL JOIN user_item ";
        $query .= "NATURAL JOIN user ";
        $query .= "WHERE username = '{$username}';";
        return $database->query($query);
    }

    // create a new item for the given username
    public static function createItem($itemName, $itemPrice, $itemDescription, 
            $itemImage, $username) {
        global $database;
        // insert item into item table
        $query = "INSERT INTO item (itemName, itemPrice, itemDescription, "
                . "itemImage) ";
        $query .= "VALUES ('{$itemName}', {$itemPrice}, '{$itemDescription}', "
                . "'{$itemImage}');";
        $result = $database->query($query);
        $itemID = $database->getLastInsertID();
        // insert item into user_item table
        $secondQuery = "INSERT INTO user_item (itemID, username) ";
        $secondQuery .= "VALUES ({$itemID}, '{$username}');";
        $secondResult = $database->query($secondQuery);
        return $result && $secondResult;
    }

    // delete the item for the given username
    public static function deleteItem($itemID, $username) {
        global $database;
        // Delete item from user_item table.
        $query = "DELETE FROM user_item ";
        $query .= "WHERE itemID = {$itemID} ";
        $query .= "AND username = '{$username}';";
        $result = $database->query($query);
        // Delete item from item table;
        $secondQuery = "DELETE FROM item ";
        $secondQuery .= "WHERE itemID = {$itemID};";
        $secondResult = $database->query($secondQuery);
        return $result && $secondResult;
    }

    // update the item information for the given item ID
    public static function updateItem($itemID, $itemName, $itemPrice, 
            $itemDescription, $itemImage) {
        global $database;
        $query = "UPDATE item ";
        $query .= "SET itemName = '{$itemName}', ";
        $query .= "itemPrice = {$itemPrice}, ";
        $query .= "itemDescription = '{$itemDescription}', ";
        $query .= "itemImage = '{$itemImage}' ";
        $query .= "WHERE itemID = {$itemID};";
        return $database->query($query);
    }

    // get the ID of the item given its information
    public static function getItemID($itemName, $itemPrice, $itemDescription) {
        global $database;
        $getIDQuery = "SELECT itemID FROM item ";
        $getIDQuery .= "WHERE itemName = '{$itemName}' ";
        $getIDQuery .= "AND itemPrice = {$itemPrice} ";
        $getIDQuery .= "AND itemDescription = '{$itemDescription}';";
        $row = $database->query($getIDQuery)->fetch_assoc();
        return $row['itemID'];
    }
}

?>

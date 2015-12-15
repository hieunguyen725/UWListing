<?php

// This is a backend database class that will manage the database
// connection of the system.
class MySQLDatabase {
    private $connection;
    
    // construct and open a new dabatbase connection
    function __construct() {
        $this->openConnection();
    }
    
    // get the id of the last insert
    public function getLastInsertID() {
        return $this->connection->insert_id;
    }
    
    // open a new mysqli database connection
    private function openConnection() {
        $this->connection = new mysqli("localhost", 
                "root", "", "uwtlisting");
        if ($this->connection->connect_errno) {
            die("Database connection failed: " . $this->connection->connect_error);
        }
    }   
    
    // close the current database connection
    public function closeConnection() {
        if (isset($this->connection)) {
            $this->connection->close();
            unset($this->connection);
        }
    }
    
    // given the query string, query the database and return the result
    public function query($sqlQuery) {
        $result = $this->connection->query($sqlQuery);
        if (!$result) {
            die("Database query failed: " . $this->connection->error);
        }
        return $result;
    }
    
    // escape the value from the user's inputs
    public function escapeValue($value) {
        return $this->connection->real_escape_string($value);
    }
}

$database = new MySQLDatabase();
?>
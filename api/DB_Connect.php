<?php
class DB_Connect {
    private $conn;
    // Connecting to database
    public function connect() {
        // Connecting to mysql database
        $this->conn = new mysqli('localhost','petkeepe_appointment','gcwtkycs1997#','petkeepe_appointment');
         
        // return database handler
        return $this->conn;
    }
}
 
?>
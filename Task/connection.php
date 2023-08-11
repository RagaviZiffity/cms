
<?php

class DatabaseConnection {
    private $servername = "localhost";
    private $dbName = "root";
    private $dbPassword = "Admin@123";
    private $dbname = "userDetails";
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->servername, $this->dbName, $this->dbPassword, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function closeConnection() {
        $this->conn->close();
    }
}

// $database = new DatabaseConnection();
// $conn = $database->getConnection();

?>

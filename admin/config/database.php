<?php
class Database{
    
    // Database Creds:
    private $host = "localhost";
    private $db_name = "lcg";
    private $username = "root";
    private $password = "foobar";
    
    public $conn;
  
    // Database connection
    public function getConnection(){
  
        $this->conn = null;
  
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
  
        return $this->conn;
    }
}
?>

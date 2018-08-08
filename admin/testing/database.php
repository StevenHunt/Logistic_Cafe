<?php

class Database{
    
    // Database Creds:
    private $host = "***************";
    private $db_name = "***";
    private $username = "******";
    private $password = "********";
    
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

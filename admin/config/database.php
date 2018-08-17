<?php
class Database{
    
    // Database Creds:
    private $host = "cst438.xxxxxxxxxxxxx.us-west-2.rds.amazonaws.com:3306";
    private $db_name = "lcg";
    private $username = "xxxx";
    private $password = "xxxx";
    
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

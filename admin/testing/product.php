<?php

class Product {
 
    private $conn;
    private $table_name = "products";
 
    // Obj Props
    public $id;
    public $name;
    public $price;
    public $description;
    public $catid;
    public $timestamp;
 
    public function __construct($db) {
        $this->conn = $db;
    }
 
    // Create Product: 
    function create() {
 
        $query = "INSERT INTO " . $this->table_name . "
                  SET name=:name, price=:price, description=:description, catid=:catid, created=:created";
 
        $stmt = $this->conn->prepare($query);

        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->catid=htmlspecialchars(strip_tags($this->catid));
 
        $this->timestamp = date('Y-m-d H:i:s');
  
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":catid", $this->catid);
        $stmt->bindParam(":created", $this->timestamp);
 
        if($stmt->execute()) {
            return true;
        }
        else {
            return false;
        }
    }
    
    // Read All: Populate admin/index
    function readAll($from_record_num, $records_per_page) {
 
    $query = "SELECT id, name, description, price, catid
              FROM " . $this->table_name . "
              ORDER BY name ASC
              LIMIT {$from_record_num}, {$records_per_page}";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
 
    return $stmt;
    }
    
    // Count All: For paging
    public function countAll() {

        $query = "SELECT id FROM " . $this->table_name . "";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        $num = $stmt->rowCount();

        return $num;
    }
    
    // Read One: Displaying individual menu item details
    function readOne() {
 
        $query = "SELECT name, price, description, catid
                  FROM " . $this->table_name . "
                  WHERE id = ?
                  LIMIT 0,1";

        $stmt = $this->conn->prepare( $query );
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['name'];
        $this->price = $row['price'];
        $this->description = $row['description'];
        $this->catid = $row['catid'];
    }
    
    function update(){
 
        $query = "UPDATE " . $this->table_name . "
                  SET name = :name, price = :price, description = :description, catid  = :catid
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->catid=htmlspecialchars(strip_tags($this->catid));
        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':catid', $this->catid);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()) {
            return true;
        }

        return false;
    }
    
}
?>

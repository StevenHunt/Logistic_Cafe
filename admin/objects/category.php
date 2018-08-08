<?php

    class Category {

        private $conn;
        private $table_name = "categories";

        // Obj Properties
        public $id;
        public $name;

        // Constructor
        public function __construct($db) {
            $this->conn = $db;
        }

        // Read: Reads name and id based on name
        function read() {
            
            $query = "SELECT id, name
                      FROM " . $this->table_name . "
                      ORDER BY name";  

            $stmt = $this->conn->prepare( $query );
            $stmt->execute();

            return $stmt;
        }
        
        // Read Name: Read cat name by id. 
        function readName(){

            $query = "SELECT name FROM " . $this->table_name . " WHERE id = ? limit 0,1";

            $stmt = $this->conn->prepare( $query );
            $stmt->bindParam(1, $this->id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->name = $row['name'];
        }

    }
?>
<?php

    // For pagination: 
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $records_per_page = 5;
    $from_record_num = ($records_per_page * $page) - $records_per_page;

    include_once 'config/database.php';
    include_once 'objects/product.php';
    include_once 'objects/category.php';

    // Instantiate DataBase and Objects
    $database = new Database();
    $db = $database->getConnection();

    $product = new Product($db);
    $category = new Category($db);

    // Query Products: 
    $stmt = $product->readAll($from_record_num, $records_per_page);
    
    // Return num of rows effected by the prev. statement
    $num = $stmt->rowCount();
    
    // Display products (if any)
    if($num>0) {

            /* Insert table formatting here */
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                extract($row);
                
                    echo $name};
                    echo $price;
                    echo $description;
        
                    $category->id = $category_id;
                    $category->readName();
        
                    echo $category->name;
                    
            }
            
        // Close table

        // Pagination  ------------------------------------------------ 
        $page_url = "index.php?";

        // Calc pages: 
        $total_rows = $product->countAll();
    }

    // No products: 
    else {
        
        echo "<div class='alert alert-info'>No products found.</div>";
    }

?>

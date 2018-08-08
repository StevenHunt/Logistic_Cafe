<?php

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $records_per_page = 5;
    $from_record_num = ($records_per_page * $page) - $records_per_page;

    include_once 'config/database.php';
    include_once 'objects/product.php';
    include_once 'objects/category.php';

    // Instantiate DB + Obj
    $database = new Database();
    $db = $database->getConnection();

    $product = new Product($db);
    $category = new Category($db);

    // Query Products: 
    $stmt = $product->readAll($from_record_num, $records_per_page);
    $num = $stmt->rowCount();

    // set page header
    $page_title = "Menu Items";
    include_once "inc/header.php";
    include_once "inc/nav.php"; 

    echo '<br><br><br><br>';

    // Add product: 
    echo "<div class='right-button-margin'>";
        echo "<a href='addproduct.php' class='btn btn-default pull-right'>Add Product</a>";
    echo "</div>";

    // Display Products (if any) 
    if($num>0){

        echo "<table class='table table-hover table-responsive table-bordered'>";
            echo "<tr>";
                echo "<th>Menu Item</th>";
                echo "<th>Price</th>";
                echo "<th>Description</th>";
                echo "<th>Actions</th>";
            echo "</tr>";

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

                extract($row);

                echo "<tr>";
                    echo "<td>{$name}</td>";
                    echo "<td>{$price}</td>";
                    echo "<td>{$description}</td>";
                    echo "<td>";

                        // Details button: 
                        echo "<a href='read_one.php?id={$id}' class='btn btn-primary left-margin'>";
                        echo "<span class='glyphicon glyphicon-list'></span> Details";
                        echo "</a>";

                        echo '&nbsp' . '&nbsp'; 

                        // Edit button: 
                        echo "<a href='editproduct.php?id={$id}' class='btn btn-info left-margin'>";
                        echo "<span class='glyphicon glyphicon-edit'></span> Edit";
                        echo "</a>";

                echo "</tr>";
            }
        echo "</table>";

        // Paging: 
        $page_url = "index.php?";

        // Calc pages: 
        $total_rows = $product->countAll();

        // Paging buttons: 
        include_once 'paging.php';
    }

    // No products: 
    else {
        
        echo "<div class='alert alert-info'>No products found.</div>";
    }

?>

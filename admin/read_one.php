<?php

    // ID of product: 
    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

    include_once 'config/database.php';
    include_once 'objects/product.php';
    include_once 'objects/category.php';

    $database = new Database();
    $db = $database->getConnection();

    $product = new Product($db);
    $category = new Category($db);

    // ID product to be read: 
    $product->id = $id;

    // Read details of product: 
    $product->readOne();

    $page_title = "Product Details";
    include_once "inc/header.php";
    include_once "inc/nav.php"; 

    echo '<br><br><br><br>';

    // Details Button: 
    echo "<div class='right-button-margin'>";
        echo "<a href='index.php' class='btn btn-primary pull-right'>";
            echo "<span class='glyphicon glyphicon-list'></span> Menu Items";
        echo "</a>";
    echo "</div>";

    echo "<table class='table table-hover table-responsive table-bordered'>";

        echo "<tr>";
            echo "<td>Name</td>";
            echo "<td>{$product->name}</td>";
        echo "</tr>";

        echo "<tr>";
            echo "<td>Price</td>";
            echo "<td>&#36;{$product->price}</td>";
        echo "</tr>";

        echo "<tr>";
            echo "<td>Description</td>";
            echo "<td>{$product->description}</td>";
        echo "</tr>";
    echo "</table>";

?>

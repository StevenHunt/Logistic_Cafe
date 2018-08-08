<?php

    // ID of product: 
    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
    
    // Include inorder to use class methods and objects
    include_once 'config/database.php';
    include_once 'objects/product.php';
    include_once 'objects/category.php';
    
    // Instantiate DB and Objects
    $database = new Database();
    $db = $database->getConnection();

    $product = new Product($db);
    $category = new Category($db);

    // ID product to be read: 
    $product->id = $id;

    // Read details of a product: 
    $product->readOne();

    /* Insert table formatting here */
    echo '<table>';
    echo '<tr>';
    echo "<td>{$product->name}</td>";
    echo "<td>&#36;{$product->price}</td>";
    echo "<td>{$product->description}</td>";
    echo '</tr>';
    echo '</table>';
?>

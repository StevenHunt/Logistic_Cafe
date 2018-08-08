<?php

    // Product ID: 
    $id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

    // Include in order to use class objects and methods: 
    include_once 'config/database.php';
    include_once 'objects/product.php';
    include_once 'objects/category.php';
    
    // Instantiating DB and Objects
    $database = new Database();
    $db = $database->getConnection();

    $product = new Product($db);
    $category = new Category($db);

    $product->id = $id;
    
    // Reads only one specified item
    $product->readOne();

?>

<?php 
    
    // IF Submitted: 
    if($_POST) {

        // Set properties: 
        $product->name = $_POST['name'];
        $product->price = $_POST['price'];
        $product->description = $_POST['description'];
        $product->catid = $_POST['catid'];

        // Update item confirmation: 
        if($product->update()) {
            
            echo "UPDATED";
        }

        else{
            echo "FAIL";
        }
    }
?>
    // PHP_SELF: a super global variable that returns the filename of the currently executing script.
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
      
        /* Insert table formatting here */
            
            // Name
            <input type='text' name='name' value='<?php echo $product->name; ?>'/>
            
            // Price
            <input type='text' name='price' value='<?php echo $product->price; ?>' />
            
            // Description
            <textarea name='description'><?php echo $product->description; ?></textarea>
            
            // Category
            <?php
              
              $stmt = $category->read();

              echo "<select name='catid'>";
              echo "<option> Selection One... </option>";
              
              while ($row_category = $stmt->fetch(PDO::FETCH_ASSOC)){
              
                $catid=$row_category['id'];
                $category_name = $row_category['name'];

                if($product->catid==$catid) {                 
                  echo "<option value='$catid' selected>";
                }
                                
                else {
                  echo "<option value='$catid'>";
                }
              
                echo "$category_name</option>";
              }
              echo "</select>";  ?>
              
              <button type="submit">Update</button>
    </form>

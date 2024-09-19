<?php
// Include database connection
include('database.php');

// Get form data
$product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
$product_name = filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_STRING);
$category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
$list_price = filter_input(INPUT_POST, 'list_price', FILTER_VALIDATE_FLOAT);
$discount_percent = filter_input(INPUT_POST, 'discount_percent', FILTER_VALIDATE_FLOAT);

// Validate inputs
if ($product_id && $product_name && $category_id && $list_price && $discount_percent !== false) {
    // Update the product in the database
    $query = 'UPDATE products
              SET product_name = :product_name,
                  category_id = :category_id,
                  list_price = :list_price,
                  discount_percent = :discount_percent
              WHERE product_id = :product_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':product_id', $product_id);
    $statement->bindValue(':product_name', $product_name);
    $statement->bindValue(':category_id', $category_id);
    $statement->bindValue(':list_price', $list_price);
    $statement->bindValue(':discount_percent', $discount_percent);
    $statement->execute();
    $statement->closeCursor();

    // Redirect to the product list page
    header('Location: product_list.php');
} else {
    // Handle invalid input
    $error = "Invalid product data. Check all fields and try again.";
    include('error.php');
}
?>
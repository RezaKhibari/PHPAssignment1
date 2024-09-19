<?php
// Include database connection
include('database.php');

// Get the product ID from the URL
$product_id = filter_input(INPUT_GET, 'product_id', FILTER_VALIDATE_INT);

// Retrieve product details
$query = 'SELECT * FROM products WHERE product_id = :product_id';
$statement = $db->prepare($query);
$statement->bindValue(':product_id', $product_id);
$statement->execute();
$product = $statement->fetch();
$statement->closeCursor();

// Fetch categories for the dropdown list
$queryCategories = 'SELECT * FROM categories';
$statementCategories = $db->prepare($queryCategories);
$statementCategories->execute();
$categories = $statementCategories->fetchAll();
$statementCategories->closeCursor();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
</head>
<body>
    <h1>Edit Product</h1>
    <form action="update_product.php" method="post">
        <!-- Include the product ID as a hidden field -->
        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">

        <!-- Product Name -->
        <label>Product Name:</label>
        <input type="text" name="product_name" value="<?php echo $product['product_name']; ?>" required><br>

        <!-- Category ID (Dropdown) -->
        <label>Category:</label>
        <select name="category_id" required>
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['category_id']; ?>" 
                    <?php if ($category['category_id'] == $product['category_id']) echo 'selected'; ?>>
                    <?php echo $category['category_name']; ?>
                </option>
            <?php endforeach; ?>
        </select><br>

        <!-- List Price -->
        <label>List Price:</label>
        <input type="number" name="list_price" step="0.01" min="0" value="<?php echo $product['list_price']; ?>" required><br>

        <!-- Discount Percent -->
        <label>Discount Percent:</label>
        <input type="number" name="discount_percent" step="0.01" min="0" max="100" value="<?php echo $product['discount_percent']; ?>" required><br>

        <!-- Update Button -->
        <input type="submit" value="Update Product">
    </form>
</body>
</html>
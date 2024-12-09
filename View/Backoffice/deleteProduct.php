<?php
// Include the required files
include_once '../../Controller/ProductController.php';

// Check if the request method is POST and if the product ID is provided
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $product_id = (int)$_POST['id']; // Ensure ID is an integer

    // Instantiate the ProductController
    $productController = new ProductController();

    // Call the deleteProduct method from ProductController
    if ($productController->deleteProduct($product_id)) {
        // Redirect to the products list after successful deletion
        header("Location: products.php?success=1");
        exit();
    } else {
        // Include the product ID in the URL for debugging
        header("Location: products.php?error=1&id=" . $product_id);
        exit();
    }
} else {
    echo "Error: No product ID provided.";
}

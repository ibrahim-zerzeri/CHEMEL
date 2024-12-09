<?php
// Include the required files
include_once '../../Controller/ProductController.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form inputs and sanitize them
    $productName = htmlspecialchars($_POST['productName']);
    $productCategory = htmlspecialchars($_POST['productCategory']);
    $productPrice = (float)$_POST['productPrice'];
    $productQuantity = (int)$_POST['productQuantity'];
    $productDescription = htmlspecialchars($_POST['productDescription']);
    $productImage = isset($_FILES['productImage']) ? $_FILES['productImage'] : null;

    // Validate that required fields are filled
    if (empty($productName) || empty($productCategory) || empty($productPrice) || empty($productQuantity) || empty($productDescription)) {
        header("Location: products.php?error=Missing required fields");
        exit();
    }

    // Create a Product object (Note: The constructor requires arguments, so pass null for the non-required ones)
    $product = new Product(
        null, // ID (auto-incremented by the database)
        $productName, 
        $productCategory, 
        $productPrice, 
        $productQuantity, 
        $productDescription, 
        null, // Image path (set later after upload)
        true  // is_shown (default is true, meaning product is visible)
    );

    // Instantiate the ProductController
    $productController = new ProductController();

    // Call the addProduct method
    try {
        // Call the controller method to add the product
        $productController->addProduct($product, $productImage);
        // Redirect to products page with success message
        header("Location: products.php?success=Product added successfully");
        exit();
    } catch (Exception $e) {
        // Redirect with an error message if something goes wrong
        header("Location: products.php?error=" . urlencode('Error adding product: ' . $e->getMessage()));
        exit();
    }
} else {
    echo "Error: Invalid request method.";
}
?>

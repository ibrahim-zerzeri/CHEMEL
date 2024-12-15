<?php
session_start();

if (!(isset($_SESSION['user']))){  
    header("location:SIGNIN.php",true);
}
include_once '../../Controller/BasketController.php';

$basketController = new BasketController();
$productController = new ProductController();

// Check if basket_id and product_id are provided in the URL
if (isset($_GET['basket_id']) && isset($_GET['product_id'])) {
    $basketId = (int)$_GET['basket_id'];
    $productId = (int)$_GET['product_id'];
    $productQuantity = $basketController->getProductQuantity($productId, $basketId);
    $product=$productController->getProductById($productId);
    // Call the method to remove the product
    $basketController->removeProductFromBasket($basketId, $productId);
    $productController->updateProductQuantity($productId, $productQuantity + $product['QUANTITY']); // Update the product quantity->

    // Redirect back to the cart page
    header("Location: cart.php?success=Product removed");
    exit();
} else {
    // Redirect with an error message if parameters are missing
    header("Location: cart.php?error=Invalid request");
    exit();
}
?>

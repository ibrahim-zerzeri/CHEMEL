<?php
session_start();
include_once '../../config.php';
include_once '../../Controller/BasketController.php';

$basketController = new BasketController();

// Check if basket_id and product_id are provided in the URL
if (isset($_GET['basket_id']) && isset($_GET['product_id'])) {
    $basketId = (int)$_GET['basket_id'];
    $productId = (int)$_GET['product_id'];

    // Call the method to remove the product
    $basketController->removeProductFromBasket($basketId, $productId);

    // Redirect back to the cart page
    header("Location: cart.php?success=Product removed");
    exit();
} else {
    // Redirect with an error message if parameters are missing
    header("Location: cart.php?error=Invalid request");
    exit();
}
?>

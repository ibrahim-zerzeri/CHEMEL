<?php
// Include the required files
include_once '../../Controller/BasketController.php';

// Check if the request method is GET and if the product ID is provided
if ( isset($_GET['id'])) {
    $basket_id = (int)$_GET['id']; // Ensure ID is an integer

    // Instantiate the ProductController
    $basketController = new BasketController();

    // Call the deletebasket method from ProductController
    if ($basketController->deleteBasket($basket_id)) {
        // Redirect to the baskets list after successful deletion
        header("Location: basket.php?success=1");
        exit();
    } else {
        // Include the basket ID in the URL for debugging
        header("Location: basket.php?error=1&id=" . $basket_id);
        exit();
    }
} else {
    echo "Error: No basket ID provided.";
}

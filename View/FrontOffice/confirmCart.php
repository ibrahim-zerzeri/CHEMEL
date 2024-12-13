<?php
session_start();

include_once '../../Controller/BasketController.php';

$basketController = new BasketController();

// Get the current basket ID from the session (or wherever it is stored)
$currentBasketId = $_SESSION['basket_id'];
$totalQuantity = $_SESSION['totalQuantity'];

// Finalize the current basket (you can add any logic you need here to update the basket status)
//$basketController->finalizeBasket($currentBasketId);

// Create a new empty basket for the user
$newBasketId = $basketController->createBasket();

// Update the session to reflect the new basket
$_SESSION['basket_id'] = $newBasketId;
$_SESSION['totalQuantity'] = 0;

// Redirect the user to the checkout page
header("Location: cart.php");
exit();
?>

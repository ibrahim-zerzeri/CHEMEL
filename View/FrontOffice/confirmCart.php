<?php
session_start();

if (!(isset($_SESSION['user']))){  
    header("location:SIGNIN.php",true);
}

include_once '../../Controller/BasketController.php';

$basketController = new BasketController();

// Get the current basket ID from the session (or wherever it is stored)
$currentBasketId = $_SESSION['basket_id'];
$totalQuantity = $_SESSION['totalQuantity'];
$user = $_SESSION['user'];
$userId = $user->id;
// Finalize the current basket (you can add any logic you need here to update the basket status)
//$basketController->finalizeBasket($currentBasketId);

// Create a new empty basket for the user

$latestBasketId = $basketController->getLatestBasketForUser($userId);
$quantityOfLatestBasket= $basketController->getTotalQuantity($latestBasketId);
if ($latestBasketId!==null && $quantityOfLatestBasket===0) {
$_SESSION['basket_id'] = $latestBasketId;
$_SESSION['totalQuantity'] = $quantityOfLatestBasket;
header("Location: cart.php");
} else {
    $_SESSION['basket_id'] = $basketController->createBasket($userId);
    $_SESSION['totalQuantity'] = 0;
    header("Location: checkout.php");
    
}



// Update the session to reflect the new basket


// Redirect the user to the checkout page

exit();
?>


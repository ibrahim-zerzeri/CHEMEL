<?php
include '../../controller/BasketController.php';
include '../../controller/UserController.php';

// Check if 'id' is set and is a valid integer
if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $userid = intval($_GET["id"]);

    // Initialize the controller
    $userC = new UserController();

    // Call the deleteOffer method
    $userC->deleteUser($userid);
        // Redirect to the offer list page on successful deletion
        header('Location:User-management.php');
        exit;
}
       

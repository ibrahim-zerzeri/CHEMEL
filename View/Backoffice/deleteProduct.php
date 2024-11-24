<?php
// Use include_once to ensure the file is included only once
include_once '../../config.php';

// Check if the ID is passed via POST
if (isset($_POST['id'])) {
    $product_id = $_POST['id'];

    // Create a PDO connection
    $conn = config::getConnexion();

    // SQL query to delete the product from the database
    $sql = "DELETE FROM product WHERE ID = :id";
    $stmt = $conn->prepare($sql);

    // Bind the product ID parameter
    $stmt->bindParam(':id', $product_id, PDO::PARAM_INT);

    // Execute the query and check if the product was deleted
    if ($stmt->execute()) {
        // Redirect to the products list after deletion
        header("Location: products.php");
        exit();
    } else {
        echo "Error: Could not delete product.";
    }
} else {
    echo "Error: No product ID provided.";
}
?>

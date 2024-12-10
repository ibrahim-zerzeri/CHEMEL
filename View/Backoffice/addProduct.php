<?php
// Include the database configuration file
include_once '../../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $productName = $_POST['productName'];
    $productCategory = $_POST['productCategory'];
    $productPrice = $_POST['productPrice'];
    $productQuantity = $_POST['productQuantity'];
    $productDescription = $_POST['productDescription'];

    // Handle file upload
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] == 0) {
        // Get file details
        $fileTmpPath = $_FILES['productImage']['tmp_name'];
        $fileName = $_FILES['productImage']['name'];

        // Define the target directory for the uploaded image (absolute path)
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/CHEMEL/uploads/';
        $filePath = $uploadDir . $fileName;

        // Define the relative path to be stored in the database
        $relativePath = '../../uploads/' . $fileName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($fileTmpPath, $filePath)) {
            // File uploaded successfully
            $imagePath = $relativePath; // Use the relative path
        } else {
            // Error uploading file
            echo "Error uploading image.";
            exit();
        }
    } else {
        // Handle case where no image is uploaded
        echo "Please upload an image.";
        exit();
    }

    // Connect to the database
    $conn = config::getConnexion();

    // SQL query to insert product data into the database
    $sql = "INSERT INTO product (PRODUCT_NAME, CATEGORY, PRICE, QUANTITY, DESCRIPTION, IMAGE_PATH) 
            VALUES (:productName, :productCategory, :productPrice, :productQuantity, :productDescription, :imagePath)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':productName', $productName, PDO::PARAM_STR);
    $stmt->bindParam(':productCategory', $productCategory, PDO::PARAM_STR);
    $stmt->bindParam(':productPrice', $productPrice, PDO::PARAM_STR);
    $stmt->bindParam(':productQuantity', $productQuantity, PDO::PARAM_INT);
    $stmt->bindParam(':productDescription', $productDescription, PDO::PARAM_STR);
    $stmt->bindParam(':imagePath', $imagePath, PDO::PARAM_STR);

    // Execute the query
    if ($stmt->execute()) {
        echo "<script>alert('Product added successfully!'); window.location.href='products.php';</script>";
    } else {
        echo "Error: Could not add product.";
    }
}
?>

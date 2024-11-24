<?php
// Include database configuration file
include('./../../config.php');

// Get the product ID from the URL (if editing an existing product)
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch existing product details from the database using PDO
    $conn = config::getConnexion();
    $sql = "SELECT * FROM product WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch();
} else {
    // Redirect to products page if ID is not provided
    header("Location: products.php");
    exit();
}

// Handle form submission for updating product
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['PRODUCT_NAME'];
    $category = $_POST['CATEGORY'];
    $price = $_POST['PRICE'];
    $quantity = $_POST['QUANTITY'];
    $description = $_POST['DESCRIPTION'];
    $imagePath = $product['IMAGE_PATH']; // Default to the existing image

    // Handle the image upload
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] == 0) {
        $imageTmpName = $_FILES['productImage']['tmp_name'];
        $imageName = basename($_FILES['productImage']['name']);
        $uploadDir = './../../uploads/'; // Use relative path for the database
        $uniqueImageName = uniqid() . '.' . pathinfo($imageName, PATHINFO_EXTENSION);
        $imagePath = $uploadDir . $uniqueImageName;

        // Move the uploaded file to the 'uploads' directory
        if (!move_uploaded_file($imageTmpName, __DIR__ . '/../../uploads/' . $uniqueImageName)) {
            echo "Error: Could not upload the image.";
        }
    }

    // Update the product in the database using PDO
    $update_sql = "UPDATE product SET PRODUCT_NAME = :PRODUCT_NAME, CATEGORY = :CATEGORY, PRICE = :PRICE, QUANTITY = :QUANTITY, DESCRIPTION = :DESCRIPTION, IMAGE_PATH = :IMAGE_PATH WHERE ID = :ID";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bindParam(':PRODUCT_NAME', $name, PDO::PARAM_STR);
    $update_stmt->bindParam(':CATEGORY', $category, PDO::PARAM_STR);
    $update_stmt->bindParam(':PRICE', $price, PDO::PARAM_STR);
    $update_stmt->bindParam(':QUANTITY', $quantity, PDO::PARAM_INT);
    $update_stmt->bindParam(':DESCRIPTION', $description, PDO::PARAM_STR);
    $update_stmt->bindParam(':IMAGE_PATH', $imagePath, PDO::PARAM_STR);
    $update_stmt->bindParam(':ID', $product_id, PDO::PARAM_INT);

    if ($update_stmt->execute()) {
        echo "<script>alert('Product updated successfully!'); window.location.href='products.php';</script>";
    } else {
        echo "Error: " . $update_stmt->errorInfo()[2];
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Product</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="./assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/libs/css/style.css">
</head>
<body>
    <div class="dashboard-main-wrapper">
        <!-- Navbar code here -->

        <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">Edit Product</h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Edit Product Details</h5>
                            <div class="card-body">
                                <form method="POST" action="" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="editProductName">Product Name</label>
                                            <input type="text" class="form-control" id="editProductName" name="PRODUCT_NAME" value="<?php echo htmlspecialchars($product['PRODUCT_NAME']); ?>" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="editProductCategory">Category</label>
                                            <input type="text" class="form-control" id="editProductCategory" name="CATEGORY" value="<?php echo htmlspecialchars($product['CATEGORY']); ?>" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="editProductPrice">Price</label>
                                            <input type="number" class="form-control" id="editProductPrice" name="PRICE" value="<?php echo htmlspecialchars($product['PRICE']); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="editProductQuantity">Quantity</label>
                                            <input type="number" class="form-control" id="editProductQuantity" name="QUANTITY" value="<?php echo htmlspecialchars($product['QUANTITY']); ?>" required>
                                        </div>
                                        <div class="form-group col-md-8">
                                            <label for="editProductDescription">Description</label>
                                            <textarea class="form-control" id="editProductDescription" name="DESCRIPTION" rows="2" required><?php echo htmlspecialchars($product['DESCRIPTION']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="productImage">Product Image</label>
                                            <input type="file" class="form-control" id="productImage" name="productImage" accept="image/*">
                                            <br>
                                            <?php if ($product['IMAGE_PATH']): ?>
                                                <img src="<?php echo $product['IMAGE_PATH']; ?>" alt="Product Image" class="img-fluid" width="100">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <p><a href="products.php" class="text-secondary">Back to products</a></p>
                                    <button type="submit" class="btn btn-primary">Update Product</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>

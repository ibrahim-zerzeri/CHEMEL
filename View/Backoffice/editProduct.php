<?php
// Get the current file name
$currentPage = basename($_SERVER['PHP_SELF']);

// Include database configuration file and controller
include '../../Controller/ProductController.php';

// Check if the 'id' parameter is in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $product_id = $_GET['id'];
    $productController = new ProductController();
    $product = $productController->getProductById($product_id);
} else {
    // If 'id' is not set or invalid, redirect to products page with an error message
    header("Location: products.php?error=Invalid Product ID");
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Product</title>
    <link rel="stylesheet" href="./assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="./assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/libs/css/style.css">
</head>
<body>
    <div class="dashboard-main-wrapper">
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
                            <form method="POST" action="../../Controller/ProductController.php" enctype="multipart/form-data">
    <!-- Hidden fields for ID and Action -->
    <input type="hidden" name="ID" value="<?php echo htmlspecialchars($product['ID']); ?>">
    <input type="hidden" name="action" value="update">

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
            <input type="number" step="0.01" class="form-control" id="editProductPrice" name="PRICE" value="<?php echo htmlspecialchars($product['PRICE']); ?>" required>
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
            <?php if (!empty($product['IMAGE_PATH'])): ?>
                <img src="<?php echo htmlspecialchars($product['IMAGE_PATH']); ?>" alt="Product Image" class="img-fluid" width="100">
            <?php endif; ?>
        </div>
    </div>

    <div class="form-row">
    <div class="form-group col-md-12">
        <label for="isShown">Product Visibility</label><br>
        <input type="checkbox" name="IS_SHOWN" value="1" <?php echo ($product['IS_SHOWN'] == 1) ? 'checked' : ''; ?>> Visible
    </div>
</div>


    
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

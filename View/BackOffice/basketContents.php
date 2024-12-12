<?php
// Get the current file name
$currentPage = basename($_SERVER['PHP_SELF']);

// Include the database configuration and the BasketController
include '../../Controller/BasketController.php';

// Check if the 'id' parameter is in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $basket_id = $_GET['id'];
    $basketController = new BasketController();
    $basketContents = $basketController->getBasketContents($basket_id);
} else {
    // If 'id' is not set or invalid, redirect to basket page with an error message
    header("Location: basket.php?error=Invalid basket ID");
    exit();
}
$totalAmount = 0;
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Basket</title>
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
                            <h2 class="pageheader-title">Edit Basket Contents</h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Basket Products</h5>
                            <div class="card-body">
                           
                                    <input type="hidden" name="basket_id" value="<?php echo htmlspecialchars($basket_id); ?>">

                                    <!-- Display the products in the basket -->
                                    <?php if (!empty($basketContents)): ?>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Product Name</th>
                                                    <th>Image</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Total</th>
                                                   
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($basketContents as $item):
                                                    
                                                    $totalAmount += $item['PRICE'] * $item['quantity'];?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($item['PRODUCT_NAME']); ?></td>
                                                        <td><img src="../../uploads/<?php echo htmlspecialchars($item['IMAGE_PATH']); ?>" alt="" width="50"></td>
                                                        <td>
                                                            <?php echo htmlspecialchars($item['quantity']); ?>
                                                        </td>
                                                        <td><?php echo htmlspecialchars($item['PRICE']); ?> DT</td>
                                                        <td><?php echo htmlspecialchars($item['PRICE'] * $item['quantity']); ?> DT</td>
                                                    
                                                    </tr>
                                                <?php endforeach; ?>
                                                <tr>
    <td colspan="4" class="text-right"><strong>Total Overall:</strong></td>
    <td><strong><?php echo number_format($totalAmount, 2); ?> DT</strong></td>
</tr>
                                            </tbody>
                                        </table>

                                       <a class="btn btn-primary" href="basket.php">Baskets Management</a>
                                    <?php else: ?>
                                        <p>No products found in this basket.</p>
                                    <?php endif; ?>
                                
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

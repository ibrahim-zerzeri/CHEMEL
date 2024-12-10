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
    header("Location: products.php?error=Invalid Product ID");
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Modify product</title>
    <link rel="stylesheet" href="./assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="./assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/libs/css/style.css">
</head>
<body>
    <div class="dashboard-main-wrapper">
        <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content">
                <div class="row">
                    <div class="col-xl-12">
                        <h2 class="pageheader-title">Modify product</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <h5 class="card-header">Modify product details</h5>
                            <div class="card-body">
                                <form id="editProductForm" method="POST" action="../../Controller/ProductController.php" enctype="multipart/form-data">
                                    <input type="hidden" name="ID" value="<?php echo htmlspecialchars($product['ID']); ?>">
                                    <input type="hidden" name="action" value="update">

                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="editProductName">Product name</label>
                                            <input type="text" class="form-control" id="editProductName" name="PRODUCT_NAME" value="<?php echo htmlspecialchars($product['PRODUCT_NAME']); ?>">
                                            <p class="error-message text-danger"></p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="editProductCategory">Category</label>
                                            <input type="text" class="form-control" id="editProductCategory" name="CATEGORY" value="<?php echo htmlspecialchars($product['CATEGORY']); ?>">
                                            <p class="error-message text-danger"></p>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="editProductPrice">Price</label>
                                            <input type="number" step="0.01" class="form-control" id="editProductPrice" name="PRICE" value="<?php echo htmlspecialchars($product['PRICE']); ?>">
                                            <p class="error-message text-danger"></p>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="editProductQuantity">Quantity</label>
                                            <input type="number" class="form-control" id="editProductQuantity" name="QUANTITY" value="<?php echo htmlspecialchars($product['QUANTITY']); ?>">
                                            <p class="error-message text-danger"></p>
                                        </div>
                                        <div class="form-group col-md-8">
                                            <label for="editProductDescription">Description</label>
                                            <textarea class="form-control" id="editProductDescription" name="DESCRIPTION" rows="2"><?php echo htmlspecialchars($product['DESCRIPTION']); ?></textarea>
                                            <p class="error-message text-danger"></p>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="productImage">Product Image</label>
                                            <input type="file" class="form-control" id="productImage" name="productImage" accept="image/*">
                                            <br>
                                            <img id="imagePreview" src="<?php echo "../".htmlspecialchars($product['IMAGE_PATH']); ?>" alt="Product Image" class="img-fluid" width="100">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="isShownCheckbox">Show product</label><br>
                                            <input type="checkbox" id="isShownCheckbox" name="IS_SHOWN" value="1" 
                                                <?php echo $product['IS_SHOWN'] == 1 ? 'checked' : ''; ?>>
                                            <label for="isShownCheckbox">Show product on website</label>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Modify Product</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        const form = document.getElementById('editProductForm');
        const inputs = document.querySelectorAll('#editProductForm input, #editProductForm textarea');

        const validationRules = {
            editProductName: /^[A-Za-zÀ-ÿ0-9' -]+$/,
            editProductCategory: /^[A-Za-zÀ-ÿ0-9' -]+$/,
            editProductPrice: /^[0-9]+(\.[0-9]{1,2})?$/,
            editProductQuantity: /^[1-9][0-9]*$/,
            editProductDescription: /^[A-Za-zÀ-ÿ0-9' -]+$/
        };

        const errorMessages = {
            editProductName: 'Nom invalide (lettres, chiffres, apostrophes, espaces seulement).',
            editProductCategory: 'Catégorie invalide (lettres, chiffres, apostrophes, espaces seulement).',
            editProductPrice: 'Le prix doit être un nombre positif.',
            editProductQuantity: 'La quantité doit être un nombre entier supérieur à 0.',
            editProductDescription: 'Description invalide (lettres, chiffres, apostrophes, espaces seulement).'
        };

        inputs.forEach(input => {
            input.addEventListener('input', function() {
                validateField(input);
            });
        });

        const validateField = (input) => {
            const fieldName = input.id;
            const regex = validationRules[fieldName];
            const error = input.nextElementSibling;
            if (!input.value.trim() || !regex.test(input.value)) {
                error.textContent = errorMessages[fieldName];
                input.classList.add('is-invalid');
            } else {
                error.textContent = '';
                input.classList.remove('is-invalid');
            }
        };

        form.addEventListener('submit', function(e) {
            let isValid = true;
            inputs.forEach(input => {
                validateField(input);
                if (input.classList.contains('is-invalid')) {
                    isValid = false;
                }
            });

            if (!isValid) {
                e.preventDefault();
            }
        });

        const productImageInput = document.getElementById('productImage');
        const imagePreview = document.getElementById('imagePreview');

        productImageInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

    <script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>

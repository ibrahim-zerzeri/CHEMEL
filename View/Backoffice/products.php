<?php
// Get the current file name
$currentPage = basename($_SERVER['PHP_SELF']);

// Include database configuration file
include '../../Controller/ProductController.php';


// Fetch all products from the database to display in the table
$pController = new ProductController();
$products = $pController->listProducts();
?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Products Management</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="../../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/libs/css/style.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <style>
        .error-message {
            color: red;
            font-size: 0.9rem;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="dashboard-main-wrapper">
      <!-- navbar -->
        <!-- ============================================================== -->
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="./User-management.php">CHEMEL</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item">
                            <div id="custom-search" class="top-search-bar">
                                <input class="form-control" type="text" placeholder="Search..">
                            </div>
                        </li>
                        <li class="nav-item dropdown notification">
                            <a class="nav-link nav-icons" href="#" id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-bell"></i> <span class="indicator"></span></a>
                            <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                                <li>
                                    <div class="notification-title"> Notification</div>
                                    <div class="notification-list">
                                        <div class="list-group">
                                            <a href="#" class="list-group-item list-group-item-action active">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="../assets/images/avatar-2.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">Jeremy Rakestraw</span>accepted your invitation to join the team.
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="../assets/images/avatar-3.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">
John Abraham</span>is now following you
                                                        <div class="notification-date">2 days ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="../assets/images/avatar-4.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">Monaan Pechi</span> is watching your main repository
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="../assets/images/avatar-5.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">Jessica Caruso</span>accepted your invitation to join the team.
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-footer"> <a href="#">View all notifications</a></div>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown connection">
                            <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-fw fa-th"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right connection-dropdown">
                                <li class="connection-list">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="../assets/images/github.png" alt="" > <span>Github</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="../assets/images/dribbble.png" alt="" > <span>Dribbble</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="../assets/images/dropbox.png" alt="" > <span>Dropbox</span></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="../assets/images/bitbucket.png" alt=""> <span>Bitbucket</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="../assets/images/mail_chimp.png" alt="" ><span>Mail chimp</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="../assets/images/slack.png" alt="" > <span>Slack</span></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="conntection-footer"><a href="#">More</a></div>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../assets/images/avatar-1.jpg" alt="" class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name">
John Abraham</h5>
                                    <span class="status"></span><span class="ml-2">Available</span>
                                </div>
                                <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>Account</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-power-off mr-2"></i>Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <div class="nav-left-sidebar sidebar-dark">
    <div class="menu-list">
        <nav class="navbar navbar-expand-lg navbar-light">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">

                    <!-- Marketplace Menu -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage === 'products.php' || $currentPage === 'basket.php') ? 'active' : ''; ?>" href="#" aria-expanded="true">
                            <i class="fa fa-fw fa-rocket"></i>Marketplace
                        </a>
                        <div id="submenu-marketplace" class="submenu show"> <!-- Removed collapse class and always show -->
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link <?php echo ($currentPage === 'products.php') ? 'active' : ''; ?>" href="products.php">Products</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo ($currentPage === 'basket.php') ? 'active' : ''; ?>" href="basket.php">Baskets</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Order/Delivery Menu -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage === 'orderList.php' || $currentPage === 'livraisonList.php') ? 'active' : ''; ?>" href="#"  aria-expanded="true">
                            <i class="fa fa-fw fa-truck"></i>Order/Delivery
                        </a>
                        <div id="submenu-order-delivery" class="submenu show"> 
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link <?php echo ($currentPage === 'orderList.php') ? 'active' : ''; ?>" href="orderList.php">Order List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo ($currentPage === 'livraisonList.php') ? 'active' : ''; ?>" href="livraisonList.php">Delivery List</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- User Management Menu -->
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage === 'User-management.php') ? 'active' : ''; ?>" href="User-management.php">
                            <i class="fa fa-fw fa-users"></i>User Management
                        </a>
                    </li>

                    <!-- Learning Section -->
               
                  <li class="nav-item">
                        <a class="nav-link <?php echo ($currentPage === 'courses.php' || $currentPage === 'subjects.php' || $currentPage === 'ManageQuiz.php') ? 'active' : ''; ?>" href="#" aria-expanded="true">
                            <i class="fa fa-fw fa-book"></i>Learning
                        </a>
                        <div id="submenu-marketplace" class="submenu show"> <!-- Removed collapse class and always show -->
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link <?php echo ($currentPage === 'courses.php') ? 'active' : ''; ?>" href="courses.php">Courses</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo ($currentPage === 'subjects.php') ? 'active' : ''; ?>" href="subjects.php">Subjects</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link <?php echo ($currentPage === 'ManageQuiz.php') ? 'active' : ''; ?>" href="ManageQuiz.php">Quizzs</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                </ul>
            </div>
        </nav>
    </div>
</div>


        
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->

        <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            
                            <p class="pageheader-text">Add and remove products from the list below.</p>
                        </div>
                    </div>
                </div>
                <div class="page-header d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="pageheader-title">Products Management</h2>
                        <p class="pageheader-text">Add and remove products from the list below.</p>
                    </div>
                  
                </div>
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Add Product</h5>
                            <div class="card-body">
                            <form id="productForm" enctype="multipart/form-data" method="POST" action="addProduct.php">
    <div class="form-row">
        <!-- Champ Nom du produit -->
        <div class="form-group col-md-4">
            <label for="productName">Product name</label>
            <input type="text" class="form-control" id="productName" name="productName" >
            <p class="error-message" id="errorProductName"></p>
        </div>

        <!-- Champ Catégorie -->
        <div class="form-group col-md-4">
            <label for="productCategory">Category</label>
            <input type="text" class="form-control" id="productCategory" name="productCategory" >
            <p class="error-message" id="errorProductCategory"></p>
        </div>

        <!-- Champ Prix -->
        <div class="form-group col-md-4">
            <label for="productPrice">Price</label>
            <input type="float" class="form-control" id="productPrice" name="productPrice" >
            <p class="error-message" id="errorProductPrice"></p>
        </div>
    </div>

    <div class="form-row">
        <!-- Champ Quantité -->
        <div class="form-group col-md-4">
            <label for="productQuantity">Quantity</label>
            <input type="number" class="form-control" id="productQuantity" name="productQuantity" >
            <p class="error-message" id="errorProductQuantity"></p>
        </div>

        <!-- Champ Image -->
        <div class="form-group col-md-4">
            <label for="productImage">Product Image</label>
            <input type="file" class="form-control" id="productImage" name="productImage" accept="image/*" >
        </div>

        <!-- Champ Description -->
        <div class="form-group col-md-4">
            <label for="productDescription">Description</label>
            <textarea class="form-control" id="productDescription" name="productDescription" rows="2"></textarea>
            <p class="error-message" id="errorProductDescription"></p>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Add the product</button>
</form>
                            </div>
                        </div>
                    </div>
                </div>
                

                <div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header">Product List</h5>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="productTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Product Image</th>
                                <th>Description</th>
                                <th>Is_Shown</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
    <?php foreach ($products as $product): ?>
        <tr>
            <td><?php echo $product['ID']; ?></td>
            <td><?php echo $product['PRODUCT_NAME']; ?></td>
            <td><?php echo $product['CATEGORY']; ?></td>
            <td><?php echo $product['PRICE']; ?> DT</td>
            <td><?php echo $product['QUANTITY']; ?></td>
            <td><img src="../../uploads/<?php echo $product['IMAGE_PATH']; ?>" alt="Product Image" width="50" height="50"></td>
            <td><?php echo $product['DESCRIPTION']; ?></td>
            <td><?php echo $product['IS_SHOWN'] ? 'True' : 'False'; ?></td>
            <td>
                <!-- Edit Button -->
                <a href="editProduct.php?id=<?php echo $product['ID']; ?>" class="btn btn-primary btn-sm">Edit</a>


                
                <!-- Delete Button with Form -->
                <form method="POST" action="deleteProduct.php" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $product['ID']; ?>">
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>

            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
 
        <script>
    // Sélectionner les champs du formulaire
    const productNameInput = document.getElementById('productName');
    const productCategoryInput = document.getElementById('productCategory');
    const productPriceInput = document.getElementById('productPrice');
    const productQuantityInput = document.getElementById('productQuantity');
    const productDescriptionInput = document.getElementById('productDescription');

    // Messages d'erreur
    const errorProductName = document.getElementById('errorProductName');
    const errorProductCategory = document.getElementById('errorProductCategory');
    const errorProductPrice = document.getElementById('errorProductPrice');
    const errorProductQuantity = document.getElementById('errorProductQuantity');
    const errorProductDescription = document.getElementById('errorProductDescription');

    // Fonction pour vérifier si le champ est alphanumérique
    function isAlphaNumeric(value) {
        const regex = /^[a-zA-Z0-9 ]+$/;
        return regex.test(value);
    }

    // Contrôle de saisie pour les champs textuels
    function validateTextInput(inputElement, errorElement) {
        if (!isAlphaNumeric(inputElement.value)) {
            errorElement.textContent = 'Ce champ doit être alphanumérique (lettres et chiffres uniquement).';
        } else {
            errorElement.textContent = '';
        }
    }

    // Contrôle de saisie pour les champs de prix et quantité
    function validatePositiveNumberInput(inputElement, errorElement) {
        const value = parseFloat(inputElement.value);
        if (isNaN(value) || value <= 0) {
            errorElement.textContent = 'Veuillez saisir un nombre positif.';
        } else {
            errorElement.textContent = '';
        }
    }

    // Écoute des événements "input" (en temps réel) sur les champs
    productNameInput.addEventListener('input', () => validateTextInput(productNameInput, errorProductName));
    productCategoryInput.addEventListener('input', () => validateTextInput(productCategoryInput, errorProductCategory));
    productPriceInput.addEventListener('input', () => validatePositiveNumberInput(productPriceInput, errorProductPrice));
    productQuantityInput.addEventListener('input', () => validatePositiveNumberInput(productQuantityInput, errorProductQuantity));
    productDescriptionInput.addEventListener('input', () => validateTextInput(productDescriptionInput, errorProductDescription));

    // Événement sur la soumission du formulaire
    document.getElementById('productForm').addEventListener('submit', function(event) {
        // Valider tous les champs avant la soumission
        validateTextInput(productNameInput, errorProductName);
        validateTextInput(productCategoryInput, errorProductCategory);
        validatePositiveNumberInput(productPriceInput, errorProductPrice);
        validatePositiveNumberInput(productQuantityInput, errorProductQuantity);
        validateTextInput(productDescriptionInput, errorProductDescription);

        // Empêcher la soumission si des erreurs sont présentes
        if (
            errorProductName.textContent !== '' ||
            errorProductCategory.textContent !== '' ||
            errorProductPrice.textContent !== '' ||
            errorProductQuantity.textContent !== '' ||
            errorProductDescription.textContent !== ''
        ) {
            event.preventDefault();
            alert('Veuillez corriger les erreurs avant de soumettre le formulaire.');
        }
    });
</script>
        
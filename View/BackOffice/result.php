<?php
// Get the current file name
$currentPage = basename($_SERVER['PHP_SELF']);

// Include database configuration file and BasketController
include '../../Controller/QuizController.php';

// Initialize the BasketController
$quizController = new QuizController();

try {
    // Fetch all baskets from the database to display in the table
    $results = $quizController->results();
} catch (Exception $e) {
    echo 'Error fetching baskets: ' . $e->getMessage();
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Baskets Management</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="../../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/libs/css/style.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
</head>

<body>
    <div class="dashboard-main-wrapper">
        <!-- Navbar -->
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="./User-management.php">CHEMEL</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item">
                            <div id="custom-search" class="top-search-bar">
                                <input class="form-control" type="text" placeholder="Search..">
                            </div>
                        </li>
                        <!-- Notification and User Profile dropdown -->
                    </ul>
                </div>
            </nav>
        </div>
        <!-- Sidebar -->
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



        <!-- Page Content -->
        <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">Users quizzes results</h2>
                            <p class="pageheader-text">View users quizzes results</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Users results</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" id="basketTable">
                                        <thead>
                                            <tr>
                                                <th>Result ID</th>
                                                <th>User ID</th>
                                                <th>Score</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($results)): ?>
                                                <?php foreach ($results as $result): ?>
                                                    <tr>
                                                 
                                                        <td><?php echo $result['id']; ?></td>
                                                        <td><?php echo $result['user_id']; ?></td>
                                                        <td><?php echo $result['score']; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="3" class="text-center">No results found</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
            </div>
        </div>
 

        <!-- Footer -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <p class="text-center">© 2024 Your Company Name. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </footer>

    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="./assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="./assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="./assets/libs/js/main-js.js"></script>
</body>

</html>

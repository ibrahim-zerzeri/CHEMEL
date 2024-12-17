<?php
$currentPage = basename($_SERVER['PHP_SELF']);

include '../../Controller/QuizController.php';

$conn = config::getConnexion(); 
$sql = "SELECT * FROM quizzes";
$stmt = $conn->prepare($sql);
$stmt->execute();
$quizzes = $stmt->fetchAll();
?>

<!doctype html>
<html lang="en">

<head>
   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Quiz Management</title>
   
    <link rel="stylesheet" href="../../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="../../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/libs/css/style.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
</head>

<body>
    <div class="dashboard-main-wrapper">
    
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="./dashboard.php">Quiz Manager</a>
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
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../assets/images/avatar-1.jpg" alt="" class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name">John Doe</h5>
                                    <span class="status"></span><span class="ml-2">Available</span>
                                </div>
                                <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>Account</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-power-off mr-2"></i>Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        
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

        
        <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">Quiz Management</h2>
                            <p class="pageheader-text">Add, edit, and manage quizzes.</p>
                        </div>
                    </div>
                </div>


                <a href="addQuiz.php" class="btn btn-primary btn-sm">Add Quiz</a>

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Quiz List</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Course ID</th>
                                                <th>Subject ID</th>
                                                <th>Question</th>
                                                <th>Option A</th>
                                                <th>Option B</th>
                                                <th>Option C</th>
                                                <th>Option D</th>
                                                <th>Correct Option</th>
                                                <th>Level</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($quizzes as $quiz): ?>
                                                <tr>
                                                    <td><?php echo $quiz['id']; ?></td>
                                                    <td><?php echo $quiz['course_id']; ?></td>
                                                    <td><?php echo $quiz['subject_id']; ?></td>
                                                    <td><?php echo $quiz['question']; ?></td>
                                                    <td><?php echo $quiz['option_a']; ?></td>
                                                    <td><?php echo $quiz['option_b']; ?></td>
                                                    <td><?php echo $quiz['option_c']; ?></td>
                                                    <td><?php echo $quiz['option_d']; ?></td>
                                                    <td><?php echo $quiz['correct_option']; ?></td>
                                                    <td> <?php 
                    // Check the level and display corresponding text
                    if ($quiz['level'] == 1) {
                        echo "Easy";
                    } elseif ($quiz['level'] == 2) {
                        echo "Medium";
                    } else {
                        echo "Hard";
                    }
                ?></td>
                                                    <td>
                                                        <a href="editQuiz.php?id=<?php echo $quiz['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                                        <form method="POST" action="deleteQuiz.php" style="display:inline;">
                                                            <input type="hidden" name="id" value="<?php echo $quiz['id']; ?>">
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

    <script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>

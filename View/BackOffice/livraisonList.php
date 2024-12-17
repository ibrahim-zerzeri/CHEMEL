<?php
$currentPage = basename($_SERVER['PHP_SELF']);
include '../../controller/LivraisonController.php';
include '../../Controller/BasketController.php';
$livraisonController = new LivraisonController();
$list = $livraisonController->listLivraison(); // Liste des livraisons
?>


<!-- view/livraisons/list.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>livraison Management</title>
</head>
<body>
    <h2>livraison Management</h2>
    
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>livraison Management</title>
    <link rel="stylesheet" href="../../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="../../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/libs/css/style.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../../assets/vendor/datatables/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../../assets/vendor/datatables/css/buttons.bootstrap4.css">
    <link rel="stylesheet" href="../../assets/vendor/datatables/css/select.bootstrap4.css">
    <link rel="stylesheet" href="../../assets/vendor/datatables/css/fixedHeader.bootstrap4.css">

<!-- jQuery and Bootstrap JS in the correct livraison -->
<script src="../../assets/vendor/jquery/jquery-3.3.1.min.js"></script>


   
</head>
<body> <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
         <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
         <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="./index.html">CHEMEL</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item">
                            <div id="custom-search" class="top-search-bar">
                                <input class="form-control" type="text" placeholder="Search.">
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
                                                    <div class="notification-list-user-img"><img src="assets/images/avatar-2.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">Jeremy Rakestraw</span>accepted your invitation to join the team.
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="assets/images/avatar-3.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">
John Abraham</span>is now following you
                                                        <div class="notification-date">2 days ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="assets/images/avatar-4.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">Monaan Pechi</span> is watching your main repository
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="assets/images/avatar-5.jpg" alt="" class="user-avatar-md rounded-circle"></div>
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
                                            <a href="#" class="connection-item"><img src="assets/images/github.png" alt="" > <span>Github</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/dribbble.png" alt="" > <span>Dribbble</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/dropbox.png" alt="" > <span>Dropbox</span></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/bitbucket.png" alt=""> <span>Bitbucket</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/mail_chimp.png" alt="" ><span>Mail chimp</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="assets/images/slack.png" alt="" > <span>Slack</span></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="conntection-footer"><a href="#">More</a></div>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="./assets/images/avatar-1.jpg" alt="" class="user-avatar-md rounded-circle"></a>
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


        
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
    <div class="container-fluid dashboard-content">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Gestion des livraisons</h5>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered first">
                                <thead>
                                    <tr>
                                        <th>ID Livraison</th>
                                        <th>ID Panier (Order ID)</th>
                                        <th>Status</th>
                                        <th colspan="2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($list as $livraison) { ?>
                                    <tr>
                                        <td><?= $livraison['idL']; ?></td>
                                        <td><?= $livraison['idP']; ?></td>
                                        <td><?= $livraison['status']; ?></td>
                                        <td>
                                            <a href="updateLivraison.php?id=<?= $livraison['idL']; ?>" class="btn btn-primary btn-sm">Modifier</a>
                                        </td>
                                        <td>
                                            <a href="deleteOrder.php?id=<?= urlencode($livraison['idL']); ?>" class="btn btn-danger btn-sm">Supprimer</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="../../assets/vendor/jquery/jquery-3.3.1.min.js"></script>

<!-- Bootstrap Bundle -->
<script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>

<!-- Slimscroll -->
<script src="../../assets/vendor/slimscroll/jquery.slimscroll.js"></script>

<!-- Multi-select -->
<script src="../../assets/vendor/multi-select/js/jquery.multi-select.js"></script>

<!-- Main JS -->
<script src="../../assets/libs/js/main-js.js"></script>

<!-- DataTables core -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<!-- DataTables Bootstrap Integration -->
<script src="../../assets/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>

<!-- DataTables Buttons -->
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script src="../../assets/vendor/datatables/js/buttons.bootstrap4.min.js"></script>

<!--    ataTables Extensions -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/rowgroup/1.0.4/js/dataTables.rowGroup.min.js"></script>
<script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>

<!-- Local data-table.js (If Necessary) -->
<script src="../../assets/vendor/datatables/js/data-table.js"></script>

<script>
$(document).ready(function() {
    // Initialisation de DataTable
    $('.table').DataTable();
});
</script>

</body>
</html>
            

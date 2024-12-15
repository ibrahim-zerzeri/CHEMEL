<?php
include '../../controller/OrderController.php';

$error = "";

$order = null;
// create an instance of the controller
$orderController = new OrderController();

if (
    isset($_POST["client_name"]) && isset($_POST["product"]) && isset($_POST["address"]) &&
    isset($_POST["postal_code"]) && isset($_POST["phone"])
) {
    if (
        !empty($_POST["client_name"]) && !empty($_POST["product"]) && !empty($_POST["address"]) &&
        !empty($_POST["postal_code"]) && !empty($_POST["phone"])
    ) {
        // Assurez-vous que la classe Order a des méthodes comme getClientName, getProduct, etc.
        $order = new Order(
            null,
            $_POST['client_name'],
            $_POST['product'],
            $_POST['address'],
            $_POST['postal_code'],
            $_POST['phone']
        );

        $orderController->addOrder($order);
        header('Location:orderList.php');
    } else {
        $error = "Missing information";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Add Order - Dashboard</title>
    <!-- Custom fonts and styles-->
    <link href="../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-text mx-3">Order Management</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item active">
                <a class="nav-link" href="orderList.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Order List</span>
                </a>
            </li>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Add an Order</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <!-- Card Example -->
                        <div class="col-xl-12 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <form id="addOrderForm" action="" method="POST">
                                            <label for="client_name">Client Name:</label><br>
                                            <input class="form-control form-control-user" type="text" id="client_name" name="client_name" required><br>
                                            
                                            <label for="product">Product:</label><br>
                                            <input class="form-control form-control-user" type="text" id="product" name="product" required><br>
                                            
                                            <label for="address">Address:</label><br>
                                            <input class="form-control form-control-user" type="text" id="address" name="address" required><br>
                                            
                                            <label for="postal_code">Postal Code:</label><br>
                                            <input class="form-control form-control-user" type="text" id="postal_code" name="postal_code" required><br>
                                            
                                            <label for="phone">Phone:</label><br>
                                            <input class="form-control form-control-user" type="text" id="phone" name="phone" required><br>
                                            
                                            <button type="submit" class="btn btn-primary btn-user btn-block">Add Order</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Order Management 2024</span>
                    </div>
                </div>
            </footer>
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Bootstrap and custom scripts -->
    <script src="../../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>

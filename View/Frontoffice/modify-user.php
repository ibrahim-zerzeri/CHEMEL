<?php
// Include the necessary controller or database connection files
include '../../controller/UserController.php';  // Adjust according to your file structure

$error = "";
$userController = new UserController();

if (isset($_GET['id'])) {
    // Fetch the user's data using the provided ID
    $user = $userController->getUserById($_GET['id']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    // Check if the required fields are filled out
    if (
        !empty($_POST["username"]) && !empty($_POST["email"]) && !empty($_POST["role"])
    ) {
        // Get the data from the form
        $user = new User(
            $_POST['id'],
            $_POST['username'],
            $_POST['email'],
            $_POST['role']
        );

        // Update the user's information in the database
        $userController->updateUser($user);

        // Redirect to the user management page after successful update
        header('Location: User-management.php');
        exit;
    } else {
        $error = "Please fill out all required fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Modify User - Admin Dashboard</title>
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-text mx-3">Admin Dashboard</div>
            </a>
            <!-- Other sidebar items -->
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Navbar contents -->
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Modify User</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <!-- Modify User Card -->
                        <div class="col-xl-12 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <?php if (isset($user)) { ?>
                                            <form action="" method="POST">
                                                <label for="id">User ID:</label><br>
                                                <input class="form-control form-control-user" type="text" id="id" name="id" readonly value="<?php echo $user['id']; ?>">

                                                <label for="username">Username:</label><br>
                                                <input class="form-control form-control-user" type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>
                                                
                                                <label for="email">Email:</label><br>
                                                <input class="form-control form-control-user" type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>

                                                <label for="role">Role:</label><br>
                                                <select class="form-control form-control-user" id="role" name="role">
                                                    <option value="admin" <?php echo ($user['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                                    <option value="user" <?php echo ($user['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                                                </select>

                                                <button type="submit" class="btn btn-primary btn-user btn-block">Update User</button>
                                            </form>
                                        <?php } else { ?>
                                            <p>User not found.</p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Content Row -->

                </div>
                <!-- End of Page Content -->
            </div>
            <!-- End of Main Content -->

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>&copy; Travel Booking 2024</span>
                    </div>
                </div>
            </footer>
        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scripts -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>

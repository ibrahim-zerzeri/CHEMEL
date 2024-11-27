<?php
include '../../controller/UserController.php';
$userC = new UserController();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Handle form submission for adding user
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $role = $_POST['role'];

  $userC->addUser($username, $email, $password, $role);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Add User - Dashboard</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css" />
    <link href="css/sb-admin-2.min.css" rel="stylesheet" />
  </head>
  <body id="page-top">
    <div id="wrapper">
      <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
          <div class="sidebar-brand-text mx-3">User Management</div>
        </a>
        <hr class="sidebar-divider my-0">
        <li class="nav-item active">
          <a class="nav-link" href="userList.php">
            <i class="fas fa-fw fa-users"></i>
            <span>User List</span>
          </a>
        </li>
      </ul>
      
      <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
          <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"></nav>
          <div class="container-fluid">
            <h1 class="h3 mb-0 text-gray-800">Add New User</h1>
            <form method="POST" action="addUser.php">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required />
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required />
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required />
              </div>
              <div class="form-group">
                <label for="role">Role</label>
                <select class="form-control" id="role" name="role" required>
                  <option value="admin">Admin</option>
                  <option value="user">User</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary">Add User</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
  </body>
</html>

<?php
include '../../controller/UserController.php';
$userC = new UserController();
$list = $userC->listUsers();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>User Management - Your Website</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
  </head>
  <body id="page-top">
    <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand" href="#page-top">
          <img class="navbar-brand" src="assets/img/esprit.png" alt="logo-esprit" width="30%" height="30%" />
        </a>
        <button class="navbar-toggler text-uppercase font-weight-bold bg-primary text-white rounded" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#portfolio">Users</a></li>
            <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#about">About</a></li>
            <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="#contact">Contact</a></li>
            <li class="nav-item mx-0 mx-lg-1"><a class="nav-link py-3 px-0 px-lg-3 rounded" href="./../BackOffice/offerList.php">Dashboard</a></li>
          </ul>
        </div>
      </div>
    </nav>
    
    <header class="masthead bg-primary text-white text-center">
      <div class="container d-flex align-items-center flex-column">
        <h1 class="masthead-heading text-uppercase mb-0">USER MANAGEMENT</h1>
        <div class="divider-custom divider-light">
          <div class="divider-custom-line"></div>
          <div class="divider-custom-icon"><i class="fas fa-users"></i></div>
          <div class="divider-custom-line"></div>
        </div>
        <p class="masthead-subheading font-weight-light mb-0">Manage and view all users</p>
      </div>
    </header>
    
    <section class="page-section portfolio" id="portfolio">
      <div class="container">
        <h2 class="page-section-heading text-center text-uppercase text-secondary mb-0">USER LIST</h2>
        <div class="divider-custom">
          <div class="divider-custom-line"></div>
          <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
          <div class="divider-custom-line"></div>
        </div>
        <div class="row justify-content-center">
          <?php foreach ($list as $user) { ?>
            <div class="col-md-6 col-lg-4 mb-5">
              <div class="portfolio-item mx-auto">
                <!-- You can replace this with a user avatar or another relevant image -->
                <img class="img-fluid" src="assets/img/user-avatar.png" alt="User Avatar" />
              </div>
              <div class="portfolio-caption" align="center">
                <h4><?php echo $user['username']; ?></h4>
                <p class="text-muted"><?php echo $user['email']; ?></p>
                <p class="text-muted">Role: <?php echo $user['role']; ?></p>
                <a href="modify-user.php?id=<?php echo $user['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                <a href="delete-user.php?id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
              </div>
            </div>
          <?php } ?>
        </div>
      </div>
    </section>

    <footer class="footer text-center">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 mb-5 mb-lg-0">
            <p>Contact us at: <a href="mailto:contact@esprit.tn">contact@esprit.tn</a></p>
            <p>1, 2 rue André Ampère - 2083, Technological Pole - El Ghazala</p>
          </div>
        </div>
      </div>
    </footer>

    <div class="copyright py-4 text-center text-white">
      <div class="container"><small>Copyright &copy; Your Website 2023</small></div>
    </div>
  </body>
</html>

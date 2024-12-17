<?php 
session_start(); // Start session to manage cart data
include_once '../../Controller/BasketController.php';

if (!(isset($_SESSION['user']))){  
    header("location:SIGNIN.php",true);
}

// Initialize the controllers
$productController = new ProductController();
$basketController = new BasketController();

// Get the list of products from the database
$products = $productController->listProducts();

// Handle the "Add to Cart" action


// Get the total quantity of products in the cart
if (isset($_SESSION['basket_id']) && isset($_SESSION['totalQuantity']) && isset($_SESSION['user'])) {
  $totalQuantity = $_SESSION['totalQuantity'];
  $basketId = $_SESSION['basket_id'];
  $user_id  = $_SESSION['user'];
  // Now you can use $basketId to fetch the cart contents, etc.
} else {
  // Handle the case where basket_id is not in the session
echo "Error: Basket ID not found in the session.";
}
if (isset($_POST['add_to_cart'])) {
  $productId = $_POST['product_id'];
  $quantity = $_POST['quantity'];
  $produit=$productController->getProductById($productId);
  $quantite_disponible=$produit['QUANTITY'];
  if ($quantity > $quantite_disponible) {
    echo "<script>alert('Quantity not available');</script>";

  }else{
    $basketController->addProductToBasket($basketId,$productId, $quantity);
    $productController->UpdateProductQuantity($productId, $quantite_disponible-$quantity);
  }
  // Add the product to the basket

}
$totalQuantity=$basketController->getTotalQuantity($basketId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Courses</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="css/ionicons.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="index.php">CHEMEL</a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

		  <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item active"><a href="index.php" class="nav-link">Home</a></li>
	         
              <li class="nav-item"><a href="subjects.php" class="nav-link">Learning</a></li>
			  <li class="nav-item"><a href="marketplace.php" class="nav-link">Marketplace</a></li>
	          <li class="nav-item cta cta-colored"><a href="cart.php" class="nav-link"><span class="icon-shopping_cart"></span><?php echo htmlspecialchars('['.($totalQuantity ?? "0").']') ; ?></a></li>
            <li class="nav-item cta cta-colored"><a href="SIGNOUT.php" class="nav-link"><span class="icon-user"></span>Profile:  <?php
    echo $_SESSION['user']->username;
    ?>Logout</a></li>
	        </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->
    <!-- Header -->
    <div class="hero-wrap hero-bread" style="background-image: url('images/bg_6.jpg');">
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <h1 class="mb-0 bread">Courses</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <div class="container my-4">
        <form method="GET" action="" class="form-inline justify-content-center">
            <input type="hidden" name="subject_id" value="<?= isset($_GET['subject_id']) ? intval($_GET['subject_id']) : '' ?>">
            <input type="text" name="search" class="form-control mr-2" placeholder="Search courses..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <!-- Main Content -->
    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row">
                <?php
                // Database connection setup
                $dsn = "mysql:host=localhost;dbname=chemel;charset=utf8mb4";
                $db_user = "root";
                $db_pass = "";

                try {
                    // Establishing the PDO connection
                    $pdo = new PDO($dsn, $db_user, $db_pass);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Check if `subject_id` is provided and valid
                    $subject_id = isset($_GET['subject_id']) ? intval($_GET['subject_id']) : 0;
                    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

                    if ($subject_id > 0) {
                        // Query to fetch courses with optional search filter
                        if (!empty($searchTerm)) {
                            $stmt = $pdo->prepare("SELECT * FROM courses WHERE subject_id = :subject_id AND name LIKE :search");
                            $stmt->execute([
                                'subject_id' => $subject_id,
                                'search' => '%' . $searchTerm . '%'
                            ]);
                        } else {
                            $stmt = $pdo->prepare("SELECT * FROM courses WHERE subject_id = :subject_id");
                            $stmt->execute(['subject_id' => $subject_id]);
                        }

                        if ($stmt->rowCount() > 0) {
                            // Display each course as a card
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<div class="col-md-4 col-lg-3 ftco-animate">';
                                echo '  <div class="product">';
                                echo '    <a href="#" class="img-prod"><img class="img-fluid" src="images/default_course.jpg" alt="Course Image">';
                                echo '      <div class="overlay"></div>';
                                echo '    </a>';
                                echo '    <div class="text py-3 pb-4 px-3">';
                                echo '      <h3><a href="coursedet.php?id=' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['name']) . '</a></h3>';
                                echo '      <p class="bottom-area d-flex px-3">';
                                echo '        <a href="coursedet.php?id=' . htmlspecialchars($row['id']) . '" class="add-to-cart text-center py-2 mr-1"><span>View Details</span></a>';
                                echo '      </p>';
                                echo '    </div>';
                                echo '  </div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<div class="col-md-12 text-center">';
                            echo '  <p>No courses found for this subject.</p>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="col-md-12 text-center">';
                        echo '  <p>Invalid subject selected. Please select a valid subject.</p>';
                        echo '</div>';
                    }
                } catch (PDOException $e) {
                    echo '<div class="col-md-12 text-center">';
                    echo '  <p>Database Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="ftco-footer ftco-section">
      <div class="container">
      	<div class="row">
      		<div class="mouse">
						<a href="#" class="mouse-icon">
							<div class="mouse-wheel"><span class="ion-ios-arrow-up"></span></div>
						</a>
					</div>
      	</div>
        <div class="row mb-5">
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">CHEMEL</h2>
              <p>A website to boost our youth.</p>
              <ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-5">
                <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4 ml-md-5">
              <h2 class="ftco-heading-2">Menu</h2>
              <ul class="list-unstyled">
                <li><a href="marketplace.php" class="py-2 d-block">Marketplace</a></li>
				<li><a href="subjects.php" class="py-2 d-block">Learning</a></li>
				<li><a href="cart.php" class="py-2 d-block">Basket</a></li>
             
              </ul>
            </div>
          </div>
          
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
            	<h2 class="ftco-heading-2">Have a Questions?</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><span class="icon icon-map-marker"></span><span class="text">Esprit , Ghazella city</span></li>
	                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+216 50 000 015</span></a></li>
	                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">chemel@gmail.com</span></a></li>
	              </ul>
	            </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">

            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						  Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart color-danger" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
						  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						</p>
          </div>
        </div>
      </div>
    </footer>

    <!-- JavaScript files -->
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.stellar.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/jquery.animateNumber.min.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/scrollax.min.js"></script>
    <script src="js/google-map.js"></script>
    <script src="js/main.js"></script>
</body>
</html>

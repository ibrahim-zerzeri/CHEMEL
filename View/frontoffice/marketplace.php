<?php
session_start(); // Start session to manage cart data
include_once '../../config.php'; // Adjust path based on your folder structure

$conn = config::getConnexion();

try {
  // Query to count the total quantities
  $sql = "SELECT SUM(quantity) AS total_quantity FROM basket_products";
  $query = $conn->prepare($sql);
  $query->execute();
  $result = $query->fetch(PDO::FETCH_ASSOC);

  // Store the total quantity in a variable
  $totalQuantity = $result['total_quantity'];
} catch (Exception $e) {
  echo 'Error: ' . $e->getMessage();
}
// Fetch products for display
$sql = "SELECT * FROM product";
$stmt = $conn->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle "Add to Cart" submission
if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Fetch product details from the database
    $productQuery = $conn->prepare("SELECT * FROM product WHERE ID = :id");
    $productQuery->execute(['id' => $productId]);
    $product = $productQuery->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        // Step 1: Identify or Create a Basket for the Session
        if (!isset($_SESSION['basket_id'])) {
            // Create a new basket if none exists
            $createBasketQuery = $conn->prepare("INSERT INTO basket () VALUES ()");
            $createBasketQuery->execute();
            $_SESSION['basket_id'] = $conn->lastInsertId(); // Store the basket ID in the session
        }
        $basketId = $_SESSION['basket_id'];

        // Step 2: Add or Update the Product in the Basket
        $basketProductQuery = $conn->prepare("
            SELECT * FROM basket_products WHERE basket_id = :basket_id AND product_id = :product_id
        ");
        $basketProductQuery->execute([
            'basket_id' => $basketId,
            'product_id' => $productId
        ]);
        $existingProduct = $basketProductQuery->fetch(PDO::FETCH_ASSOC);

        if ($existingProduct) {
            // Update quantity if the product is already in the basket
            $updateBasketProductQuery = $conn->prepare("
                UPDATE basket_products 
                SET quantity = quantity + :quantity 
                WHERE basket_id = :basket_id AND product_id = :product_id
            ");
            $updateBasketProductQuery->execute([
                'quantity' => $quantity,
                'basket_id' => $basketId,
                'product_id' => $productId
            ]);
        } else {
            // Insert new product into the basket
            $insertBasketProductQuery = $conn->prepare("
                INSERT INTO basket_products (basket_id, product_id, quantity)
                VALUES (:basket_id, :product_id, :quantity)
            ");
            $insertBasketProductQuery->execute([
                'basket_id' => $basketId,
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }

        // Step 3: Update the Session Cart (Optional, for UI purposes)
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = [
              'product_name' => $product['product_name'],
              'category' => $product['category'],
              'description' => $product['description'],
              'price' => $product['price'],
              'quantity' => $quantity,
              'image_path' => $product['image_path']
            ];
        }
        

        // Redirect or display a success message
        header("Location: marketplace.php?success=1");
        exit();
    } else {
        // Handle product not found error
        header("Location: marketplace.php?error=Product not found");
        exit();
    }
}
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <title>CHEMEL</title>
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
  <body class="goto-here">
		
    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="index.php">CHEMEL</a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

		  <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item active"><a href="index.php" class="nav-link">Home</a></li>
	         
              <li class="nav-item"><a href="learning.php" class="nav-link">Learning</a></li>
			  <li class="nav-item"><a href="marketplace.php" class="nav-link">Marketplace</a></li>
			  <li class="nav-item"><a href="profile.php" class="nav-link">Profile</a></li>
	          <li class="nav-item"><a href="about.php" class="nav-link">About</a></li>
	          
	          <li class="nav-item"><a href="contact.php" class="nav-link">Contact</a></li>
	          <li class="nav-item cta cta-colored"><a href="cart.php" class="nav-link"><span class="icon-shopping_cart"></span><?php echo htmlspecialchars('['.($totalQuantity ?? "0").']') ; ?></a></li>

	        </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->

    <div class="hero-wrap hero-bread" style="background-image: url('images/bg_6.jpg');">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Shop</span></p>
            <h1 class="mb-0 bread">Shop</h1>
          </div>
        </div>
      </div>
    </div>

	<section class="ftco-section bg-light">
    <div class="container">
        <div class="row">
            <!-- Sidebar Section -->
            <div class="col-lg-3 col-md-4">
                <div class="sidebar">
                    <div class="sidebar-box-2">
                        <h2 class="heading">Categories</h2>
                        <div class="fancy-collapse-panel">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Men's Shoes</a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="panel-body">
                                            <ul>
                                                <li><a href="#">Sport</a></li>
                                                <li><a href="#">Casual</a></li>
                                                <li><a href="#">Running</a></li>
                                                <li><a href="#">Jordan</a></li>
                                                <li><a href="#">Soccer</a></li>
                                                <li><a href="#">Football</a></li>
                                                <li><a href="#">Lifestyle</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- Additional panels for other categories -->
                            </div>
                        </div>
                    </div>

                    <div class="sidebar-box-2">
                        <h2 class="heading">Price Range</h2>
                        <form method="post" class="colorlib-form-2">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="guests">Price from:</label>
                                        <div class="form-field">
                                            <i class="icon icon-arrow-down3"></i>
                                            <select name="price_from" class="form-control">
                                                <option value="1">1</option>
                                                <option value="200">200</option>
                                                <option value="300">300</option>
                                                <option value="400">400</option>
                                                <option value="1000">1000</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="guests">Price to:</label>
                                        <div class="form-field">
                                            <i class="icon icon-arrow-down3"></i>
                                            <select name="price_to" class="form-control">
                                                <option value="2000">2000</option>
                                                <option value="4000">4000</option>
                                                <option value="6000">6000</option>
                                                <option value="8000">8000</option>
                                                <option value="10000">10000</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Products Section -->
            <div class="col-lg-9 col-md-8">
                <div class="row">
                <?php foreach ($products as $product): ?>
    <div class="col-sm-12 col-md-6 col-lg-4 ftco-animate d-flex">
        <div class="product d-flex flex-column">
            <!-- Product Image -->
            <a href="#" class="img-prod">
                <img class="product-img" src="<?= htmlspecialchars($product['IMAGE_PATH']) ?>" alt="<?= htmlspecialchars($product['PRODUCT_NAME']) ?>">
                <div class="overlay"></div>
            </a>
            <!-- Product Details -->
            <div class="text py-3 pb-4 px-3">
                <div class="d-flex">
                    <div class="cat">
                        <span><?= htmlspecialchars($product['CATEGORY']) ?></span>
                    </div>
                </div>
                <h3><a href="#"><?= htmlspecialchars($product['PRODUCT_NAME']) ?></a></h3>
                <div class="pricing">
                    <p class="price"><span><?= htmlspecialchars($product['PRICE']) ?> DT</span></p>
                </div>
                <p class="bottom-area d-flex px-3">
                    <form action="marketplace.php" method="POST">
                        <input type="hidden" name="product_id" value="<?= $product['ID'] ?>">
                        <input type="number" name="quantity" value="1" min="1" class="form-control w-25" required>
                        <button type="submit" name="add_to_cart" class="add-to-cart text-center py-2 mr-1">
                            <span>Add to cart <i class="ion-ios-add ml-1"></i></span>
                        </button>
                    </form>
                </p>
            </div>
        </div>
    </div>
<?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

		
		<section class="ftco-gallery">
    	<div class="container">
    		<div class="row justify-content-center">
    			<div class="col-md-8 heading-section text-center mb-4 ftco-animate">
            <h2 class="mb-4">Follow Us On Instagram</h2>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in</p>
          </div>
    		</div>
    	</div>
    	<div class="container-fluid px-0">
    		<div class="row no-gutters">
					<div class="col-md-4 col-lg-2 ftco-animate">
						<a href="images/gallery-1.jpg" class="gallery image-popup img d-flex align-items-center" style="background-image: url(images/gallery-1.jpg);">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-instagram"></span>
    					</div>
						</a>
					</div>
					<div class="col-md-4 col-lg-2 ftco-animate">
						<a href="images/gallery-2.jpg" class="gallery image-popup img d-flex align-items-center" style="background-image: url(images/gallery-2.jpg);">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-instagram"></span>
    					</div>
						</a>
					</div>
					<div class="col-md-4 col-lg-2 ftco-animate">
						<a href="images/gallery-3.jpg" class="gallery image-popup img d-flex align-items-center" style="background-image: url(images/gallery-3.jpg);">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-instagram"></span>
    					</div>
						</a>
					</div>
					<div class="col-md-4 col-lg-2 ftco-animate">
						<a href="images/gallery-4.jpg" class="gallery image-popup img d-flex align-items-center" style="background-image: url(images/gallery-4.jpg);">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-instagram"></span>
    					</div>
						</a>
					</div>
					<div class="col-md-4 col-lg-2 ftco-animate">
						<a href="images/gallery-5.jpg" class="gallery image-popup img d-flex align-items-center" style="background-image: url(images/gallery-5.jpg);">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-instagram"></span>
    					</div>
						</a>
					</div>
					<div class="col-md-4 col-lg-2 ftco-animate">
						<a href="images/gallery-6.jpg" class="gallery image-popup img d-flex align-items-center" style="background-image: url(images/gallery-6.jpg);">
							<div class="icon mb-4 d-flex align-items-center justify-content-center">
    						<span class="icon-instagram"></span>
    					</div>
						</a>
					</div>
        </div>
    	</div>
    </section>

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
              <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia.</p>
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
                <li><a href="#" class="py-2 d-block">Shop</a></li>
                <li><a href="#" class="py-2 d-block">About</a></li>
                <li><a href="#" class="py-2 d-block">Journal</a></li>
                <li><a href="#" class="py-2 d-block">Contact Us</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-4">
             <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Help</h2>
              <div class="d-flex">
	              <ul class="list-unstyled mr-l-5 pr-l-3 mr-4">
	                <li><a href="#" class="py-2 d-block">Shipping Information</a></li>
	                <li><a href="#" class="py-2 d-block">Returns &amp; Exchange</a></li>
	                <li><a href="#" class="py-2 d-block">Terms &amp; Conditions</a></li>
	                <li><a href="#" class="py-2 d-block">Privacy Policy</a></li>
	              </ul>
	              <ul class="list-unstyled">
	                <li><a href="#" class="py-2 d-block">FAQs</a></li>
	                <li><a href="#" class="py-2 d-block">Contact</a></li>
	              </ul>
	            </div>
            </div>
          </div>
          <div class="col-md">
            <div class="ftco-footer-widget mb-4">
            	<h2 class="ftco-heading-2">Have a Questions?</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><span class="icon icon-map-marker"></span><span class="text">203 Fake St. Mountain View, San Francisco, California, USA</span></li>
	                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929 210</span></a></li>
	                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">info@yourdomain.com</span></a></li>
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
    
  

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


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
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="js/google-map.js"></script>
  <script src="js/main.js"></script>
    
  </body>
</html>
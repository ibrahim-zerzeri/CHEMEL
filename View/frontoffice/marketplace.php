<?php
session_start(); // Start session to manage cart data
include_once '../../Controller/BasketController.php';

// Initialize the controllers
$productController = new ProductController();
$basketController = new BasketController();

// Get the list of products from the database
$products = $productController->listProducts();

// Handle the "Add to Cart" action


// Get the total quantity of products in the cart
if (isset($_SESSION['basket_id']) && isset($_SESSION['totalQuantity'])) {
  $totalQuantity = $_SESSION['totalQuantity'];
  $basketId = $_SESSION['basket_id'];
  // Now you can use $basketId to fetch the cart contents, etc.
} else {
  // Handle the case where basket_id is not in the session
  echo "Basket ID not found.";
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
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Welcome</a></span> </p>
            <h1 class="mb-0 bread">To the marketplace</h1>
          </div>
        </div>
      </div>
    </div>

	<section class="ftco-section bg-light">
    <div class="container">
       

            <!-- Products Section -->
            <div class="col-lg-9 col-md-8">
                <div class="row">
                <div class="container my-5">
    <!-- Search Bar -->
    <input type="text" id="searchBar" placeholder="Search for products..." class="form-control my-4">
    
    <!-- Products Container -->
    <div id="productsContainer" class="row">
        <?php foreach ($products as $product): 
            if($product['IS_SHOWN'] == 1): ?>
            <div class="col-sm-12 col-md-6 col-lg-4 ftco-animate d-flex product-item" 
                data-name="<?= htmlspecialchars($product['PRODUCT_NAME']) ?>" 
                data-category="<?= htmlspecialchars($product['CATEGORY']) ?>">
                <div class="product d-flex flex-column">
                    <!-- Product Image -->
                    <a href="#" class="img-prod">
                        <img class="product-img img-fluid" src="../<?= htmlspecialchars($product['IMAGE_PATH']) ?>" alt="<?= htmlspecialchars($product['PRODUCT_NAME']) ?>">
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
                        <h3 style="color:red;"><?= $product['QUANTITY'] == 0 ? "Out of stock" : "" ?></h3>
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
        <?php 
            endif; 
        endforeach; ?>
    </div>
</div>
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
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
  <script>
    //Search bar dynamic
    document.addEventListener('DOMContentLoaded', function () {
        const searchBar = document.getElementById('searchBar');
        const products = document.querySelectorAll('.product-item');

        searchBar.addEventListener('keyup', function () {
            const query = searchBar.value.toLowerCase();

            products.forEach(product => {
                const productName = product.dataset.name.toLowerCase();
                const productCategory = product.dataset.category.toLowerCase();

                if (productName.includes(query) || productCategory.includes(query)) {
                  product.style.setProperty('display', 'flex', 'important');

                } else {
                  product.style.setProperty('display', 'none', 'important');

                }
                
            });
        });
    });
  //End search bar dynamic

  //Categories filtering

  //End Categories filtering
</script>
    
  </body>
</html>
<?php
session_start();

if (!(isset($_SESSION['user']))){  
    header("location:SIGNIN.php",true);
}
include '../../Controller/BasketController.php';

$productC = new ProductController();

$basket_contents = new BasketController();

$totalAmount = 0;
if (isset($_SESSION['basket_id']) && isset($_SESSION['totalQuantity'])) {
  $totalQuantity = $_SESSION['totalQuantity'];
  $basketId = $_SESSION['basket_id'];
 
  // Now you can use $basketId to fetch the cart contents, etc.
} else {
  // Handle the case where basket_id is not in the session
  echo "Error: Basket ID not found in the session.";
}
$totalQuantity=$basket_contents->getTotalQuantity($basketId);
$liste = $basket_contents->getBasketContents($basketId);






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

    <div class="hero-wrap hero-bread" style="background-image: url('images/bg_6.jpg');">
      <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate text-center">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.php">Home</a></span> <span>Cart</span></p>
            <h1 class="mb-0 bread">My Cart</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section ftco-cart">
			<div class="container">
				<div class="row">
    			<div class="col-md-12 ftco-animate">
    				<div class="cart-list">
	    				<table class="table">
						    <thead class="thead-primary">
						      <tr class="text-center">
						        <th>&nbsp;</th>
						        <th>&nbsp;</th>
						        <th>Product</th>
						        <th>Price</th>
						        <th>Quantity</th>
						        <th>Total</th>
						      </tr>
						    </thead>
							<tbody>
  
   
  

<?php
foreach ($liste as $product):
    // Get the quantity from the basket
    $quantity = $basket_contents->getProductQuantity($product['ID'],$basketId);

    // Only display the product if the quantity is greater than 0
    if ($quantity > 0):
?>
      <tr class="text-center">
        <td class="product-remove">
        <a href="remove_from_cart.php?basket_id=<?php echo $basketId; ?>&product_id=<?php echo $product['ID']; ?>">Remove</a>
       </td>
        
        <td class="image-prod">
          <div class="img" style="background-image:url('<?php echo "../".$product['IMAGE_PATH']; ?>');"> </div>
        </td>
        
		<td class="product-name">
          <h3><?php echo htmlspecialchars($product['PRODUCT_NAME']); ?></h3>
          <p><?php echo htmlspecialchars($product['DESCRIPTION']);?></p>
        </td>

        <td class="price"><?php echo number_format($product['PRICE'], 2); ?>DT</td>
        
        <td class="quantity">
        <?php echo $quantity; ?>
         
        </td>
        
        <td class="total"><?php echo number_format($product['PRICE'] * $quantity, 2); ?>DT</td>
      </tr>
      <?php $totalAmount = $totalAmount + ($product['PRICE'] * $quantity);
      $_SESSION['totalAmount'] = $totalAmount;  ?>
    <?php endif; ?>
<?php endforeach; ?>

</tbody>


						  </table>
					  </div>
    			</div>
    		</div>
    		<div class="row justify-content-start">
    			<div class="col col-lg-5 col-md-6 mt-5 cart-wrap ftco-animate">
    				<div class="cart-total mb-3">
    					<h3>Cart Totals</h3>
    				
    					<hr>
    					<p class="d-flex total-price">
    						<span>Total</span>
    						<span><?php echo number_format($totalAmount, 2); ?>DT</span>
    					</p>
    				</div>
    				<p class="text-center">  <a href="confirmCart.php" class="btn btn-primary py-3 px-4">Proceed to Checkout</a></p>
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
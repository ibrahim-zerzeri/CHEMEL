<?php
include_once(__DIR__ . '../../../controller/BasketController.php');
include_once(__DIR__ . '../../../controller/OrderController.php');
include_once(__DIR__ . '../../../model/Order.php');  // Assurez-vous d'inclure la classe Order
session_start();
$error = "";
$successMessage = "";
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

// Crée une instance du contrôleur
$orderController = new OrderController();

// Connexion à la base de données
try {
    $pdo = config::getConnexion();
    echo "Connexion à la base de données réussie.";
} catch (Exception $e) {
    echo "Connexion à la base de données échouée: " . $e->getMessage();
    exit();
}

// Traitement des données envoyées via la méthode GET
if (
    isset($_GET["client_name"]) && isset($_GET["product"]) && isset($_GET["address"]) &&
    isset($_GET["postal_code"]) && isset($_GET["phone"])
) {
    if (
        !empty($_GET["client_name"]) && !empty($_GET["product"]) && !empty($_GET["address"]) &&
        !empty($_GET["postal_code"]) && !empty($_GET["phone"])
    ) {
        // Instancier un objet Order avec les données de la requête GET
        $order = new Order(
            null,
            $_GET['client_name'],
            $_GET['product'],
            $_GET['address'],
            $_GET['postal_code'],
            $_GET['phone'],
            $basketId
        );

        // Appeler la méthode addOrder du contrôleur pour insérer la commande
        try {
            $orderController->addOrder($order);
            $successMessage = "Commande ajoutée avec succès !";
            // Vous pouvez aussi rediriger après succès, si vous le souhaitez
            // header('Location: orderList.html');
            // exit();
        } catch (Exception $e) {
            $error = "Erreur lors de l'ajout de la commande: " . $e->getMessage();
        }
        header('Location: ipay.php ');
    } else {
        $error = "Tous les champs sont requis.";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Minishop - Free Bootstrap 4 Template by Colorlib</title>
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
            <li class="nav-item cta cta-colored"><a href="SIGNOUT.php" class="nav-link"><span class="icon-shopping_cart"></span>Profile:  <?php
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
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home</a></span> <span>Checkout</span></p>
            <h1 class="mb-0 bread">Checkout</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-xl-10 ftco-animate">
						<form action="#" class="billing-form">
							<h3 class="mb-4 billing-heading">Billing Details</h3>
	          	<div class="row align-items-end">
				  
    <div class="container mt-5">
        <h2>Order Management</h2>
        <div class="card">
            
        <div class="card-body">
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="row align-items-end">
        <div class="col-md-6">
            <div class="form-group">
                <form id="addOrderForm" action="../../index.php" method="POST">
                    <label for="client_name">Nom du Client</label>
                    <input type="text" class="form-control" name="client_name" placeholder="Nom et Prénom" required>
                </div>
            </div>
            <div class="w-100"></div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="address">Adresse</label>
                    <input type="text" class="form-control" name="address" placeholder="Numéro de maison - Rue" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="postal_code">Code Postal</label>
                    <input type="text" class="form-control" name="postal_code" placeholder="Code postal" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone">Téléphone</label>
                    <input type="text" class="form-control" name="phone" placeholder="Numéro de téléphone" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="product">Produit</label>
                    <input type="text" class="form-control" name="product" placeholder="Produit (optionnel)">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary py-3 px-4" href="./creditcardPayment/ipay.php">Passer la commande</button>
                </div>
            </div>
        </form>
    </div>
    <?php if ($error): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <?php if ($successMessage): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $successMessage; ?>
            </div>
        <?php endif; ?>

</div>
    </div>

    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
 
							
        </div>
          
        </div>
      </div>
    </section> <!-- .section -->
		

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
              <h2 class="ftco-heading-2">Minishop</h2>
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

  <script>
		$(document).ready(function(){

		var quantitiy=0;
		   $('.quantity-right-plus').click(function(e){
		        
		        // Stop acting like a button
		        e.preventDefault();
		        // Get the field name
		        var quantity = parseInt($('#quantity').val());
		        
		        // If is not undefined
		            
		            $('#quantity').val(quantity + 1);

		          
		            // Increment
		        
		    });

		     $('.quantity-left-minus').click(function(e){
		        // Stop acting like a button
		        e.preventDefault();
		        // Get the field name
		        var quantity = parseInt($('#quantity').val());
		        
		        // If is not undefined
		      
		            // Increment
		            if(quantity>0){
		            $('#quantity').val(quantity - 1);
		            }
		    });
		    
		});
	</script>
    
  </body>
</html>
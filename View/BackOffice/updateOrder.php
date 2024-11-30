<?php
include '../../controller/OrderController.php';

$error = "";
$orderController = new OrderController();
$client_name = $product = $address = $postal_code = $phone = "";

// Connexion à la base de données
try {
    $pdo = DatabaseConfig::getConnexion();
    echo "Connexion à la base de données réussie.";
} catch (Exception $e) {
    echo "Connexion à la base de données échouée: " . $e->getMessage();
    exit();
}

// Vérifiez si un ID est fourni dans l'URL et récupérez les détails de la commande
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $order = $orderController->showOrder($id); // Récupération de la commande par ID

    // Si la commande existe, on assigne les valeurs aux variables
    if ($order) {
        $client_name = $order->getClientName();
        $product = $order->getProduct();
        $address = $order->getAddress();
        $postal_code = $order->getPostalCode();
        $phone = $order->getPhone();
    } else {
        $error = "Commande introuvable. Veuillez réessayer.";
    }
} else {
    $error = "Aucun ID de commande spécifié.";
}

// Gestion de la soumission du formulaire de mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["client_name"], $_POST["product"], $_POST["address"], $_POST["postal_code"], $_POST["phone"], $_POST["id"])) {
    if (!empty($_POST["client_name"]) && !empty($_POST["product"]) && !empty($_POST["address"]) && !empty($_POST["postal_code"]) && !empty($_POST["phone"])) {
        
        $order = new Order(
            (int)$_POST['id'],
            $_POST['client_name'],
            $_POST['product'],
            $_POST['address'],
            $_POST['postal_code'],
            $_POST['phone']
        );

        // Mettre à jour la commande dans la base de données
        $orderController->updateOrder($order, $_POST['id']);
        header('Location: orderList.php');
        exit();
    } else {
        $error = "Informations manquantes.";
    }
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Modifier la commande</title>
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/libs/css/style.css">
    <link rel="stylesheet" href="assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <script src="./assets/vendor/jquery/jquery-3.3.1.min.js"></script>
</head>
<body>
    <center>
        <div class="card">
            <div class="card-header">
                <h3 class="mb-1">Modifier la commande</h3>
                <p>Mettez à jour les détails de la commande ci-dessous.</p>
            </div>
            <div class="card-body">
                <?php if ($error): ?>
                    <p style="color: red;"><?php echo $error; ?></p>
                <?php endif; ?>

                <form id="updateOrderForm" action="" method="POST">
                    <label for="id">ID de la commande :</label><br>
                    <input class="form-control" type="text" id="id" name="id" readonly value="<?php echo htmlspecialchars($order->getId()); ?>">

                    <label for="client_name">Nom du Client :</label><br>
                    <input class="form-control" type="text" id="client_name" name="client_name" value="<?php echo htmlspecialchars($client_name); ?>" required><br>

                    <label for="product">Produit :</label><br>
                    <input class="form-control" type="text" id="product" name="product" value="<?php echo htmlspecialchars($product); ?>" required><br>

                    <label for="address">Adresse :</label><br>
                    <input class="form-control" type="text" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>" required><br>

                    <label for="postal_code">Code Postal :</label><br>
                    <input class="form-control" type="text" id="postal_code" name="postal_code" value="<?php echo htmlspecialchars($postal_code); ?>" required><br>

                    <label for="phone">Téléphone :</label><br>
                    <input class="form-control" type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required><br>

                    <button type="submit" class="btn btn-primary btn-block">Mettre à jour la commande</button>
                </form>
            </div>
        </div>
    </center>
</body>
</html>

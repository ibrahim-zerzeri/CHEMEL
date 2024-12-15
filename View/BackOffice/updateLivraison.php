<?php
include '../../controller/LivraisonController.php';

$error = "";
$livraisonController = new LivraisonController(); // Assurez-vous que cette ligne est présente
$idP = $status = "";

// Connexion à la base de données
try {
    $pdo = config::getConnexion();
} catch (Exception $e) {
    die("Connexion à la base de données échouée : " . $e->getMessage());
}

// Vérifiez si un ID est fourni dans l'URL et récupérez les détails de la livraison
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int)$_GET['id']; // Validation de l'ID pour s'assurer qu'il est un entier
    echo "ID de livraison : " . $id; // Pour le débogage
    $livraison = $livraisonController->showLivraison($id); // Récupération de la livraison par ID

    if ($livraison) {
        $idP = htmlspecialchars($livraison['idP']);
        $status = htmlspecialchars($livraison['status']);
    } else {
        $error = "Livraison introuvable. Veuillez réessayer.";
    }
} else {
    $error = "Aucun ID de livraison spécifié.";
}

// Gestion de la soumission du formulaire de mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["idL"], $_POST["idP"], $_POST["status"]) && !empty($_POST["idP"]) && !empty($_POST["status"])) {
        // Nettoyage des entrées utilisateur
        $livraison = [
            'idL' => (int)$_POST['idL'],
            'idP' => htmlspecialchars($_POST['idP']),
            'status' => htmlspecialchars($_POST['status'])
        ];

        // Mise à jour de la livraison
        $livraisonController->updateLivraison($livraison);

        // Redirection après mise à jour
        header('Location: livraisonList.php');
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
    <title>Modifier la Livraison</title>
    <link rel="stylesheet" href="../../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="../../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/libs/css/style.css">
    <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <script src="../../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
</head>
<body>
    <center>
        <div class="card">
            <div class="card-header">
                <h3 class="mb-1">Modifier la Livraison</h3>
                <p>Mettez à jour les détails de la livraison ci-dessous.</p>
            </div>
            <div class="card-body">
            <?php if ($error): ?>
                    <p style="color: red;"><?php echo $error; ?></p>
                <?php endif; ?>

                <form id="updateLivraisonForm" action="" method="POST">
                <label for="idL">ID Livraison :</label><br>
<input class="form-control" type="text" id="idL" name="idL" readonly value="<?php echo isset($livraison['idL']) ? htmlspecialchars($livraison['idL']) : ''; ?>">

                    <label for="idP">ID Panier :</label><br>
                    <input class="form-control" type="text" id="idP" readonly name="idP" value="<?php echo htmlspecialchars($idP); ?>" required><br>

                    <label for="status">Statut :</label><br>
                    <select class="form-control" id="status" name="status" required>
                        <option value="Not yet" <?php echo $status === 'Not yet' ? 'selected' : ''; ?>>Not Yet</option>
                        <option value="Delivered" <?php echo $status === 'Delivered' ? 'selected' : ''; ?>>Delivered</option>
                    </select><br>

                    <button type="submit" class="btn btn-primary btn-block">Mettre à jour la Livraison</button>
                </form>
            </div>
        </div>
    </center>
</body>
</html>

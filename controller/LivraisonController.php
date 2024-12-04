    <?php
    include_once '../../config.php'; 
    include(__DIR__ . '/../Model/livraison.php'); // Assurez-vous que le chemin est correct

    class LivraisonController
    {
        // Récupérer la liste des livraisons
        public function listLivraison() {
            try {
                $pdo = DatabaseConfig::getConnexion();
                $query = "SELECT * FROM livraison"; // Récupérer toutes les livraisons
                $stmt = $pdo->query($query);
                return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne les données sous forme de tableau associatif
            } catch (Exception $e) {
                echo "Erreur lors de la récupération des livraisons : " . $e->getMessage();
            }
        }

        // Ajouter une livraison
        public function addLivraisonFromOrder() {
            try {
                $pdo = DatabaseConfig::getConnexion();
        
                // Récupérer l'ID du dernier ordre ajouté
                $queryOrder = "SELECT id FROM orders ORDER BY id DESC LIMIT 1"; 
                $stmtOrder = $pdo->query($queryOrder);
                $order = $stmtOrder->fetch(PDO::FETCH_ASSOC);
        
                if ($order && isset($order['id'])) {
                    $idP = $order['id'];
                    $status = 'not yet'; // Statut par défaut
        
                    // Insérer une nouvelle livraison
                    $queryLivraison = "INSERT INTO livraison (idP, status) VALUES (:idP, :status)";
                    $stmtLivraison = $pdo->prepare($queryLivraison);
                    $stmtLivraison->execute([
                        ':idP' => $idP,
                        ':status' => $status,
                    ]);
        
                    echo "Livraison ajoutée avec succès pour l'ordre ID : $idP.";
                } else {
                    throw new Exception("Aucun ordre trouvé pour ajouter une livraison.");
                }
            } catch (Exception $e) {
                echo "Erreur lors de l'ajout automatique de la livraison : " . $e->getMessage();
            }
        }
        

        // Supprimer une livraison
        public function deleteLivraison($idL) {
            try {
                $pdo = DatabaseConfig::getConnexion();
                $query = "DELETE FROM livraison WHERE idL = :idL";
                $stmt = $pdo->prepare($query);
                $stmt->bindValue(':idL', $idL, PDO::PARAM_INT);
                $stmt->execute();
                echo "Livraison supprimée avec succès.";
            } catch (Exception $e) {
                echo "Erreur lors de la suppression de la livraison : " . $e->getMessage();
            }
        }

        // Mettre à jour une livraison
        public function updateLivraison($livraison) {
            global $pdo; // Assurez-vous que vous avez accès à la connexion PDO
            
            // Préparez la requête pour mettre à jour la livraison
            $stmt = $pdo->prepare("UPDATE livraison SET idP = :idP, status = :status WHERE idL = :idL");
            
            // Exécutez la requête avec les données fournies
            $stmt->execute([
                'idL' => $livraison['idL'],
                'idP' => $livraison['idP'],
                'status' => $livraison['status']
            ]);
        }

        // Afficher une livraison
        public function showLivraison($id) {
            $sql = "SELECT * FROM livraison WHERE idL = :idL";
            $db = DatabaseConfig::getConnexion();
            try {
                $query = $db->prepare($sql);
                $query->execute(['idL' => $id]);
                $livraison = $query->fetch(PDO::FETCH_ASSOC);
                return $livraison;
            } catch (Exception $e) {
                echo 'Erreur : ' . $e->getMessage();
                return null;
            }
        }
    }
    ?>

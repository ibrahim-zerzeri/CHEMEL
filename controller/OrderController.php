<?php
include_once '../../config.php'; 
include(__DIR__ . '/../Model/Order.php'); // Assurez-vous que le chemin de la classe Order est correct

class OrderController
{
    public function listOrders() {
        try {
            $pdo = DatabaseConfig::getConnexion(); // Utilisez DatabaseConfig de manière cohérente
            
            // Récupérer les commandes depuis la base de données
            $query = "SELECT * FROM orders";
            $stmt = $pdo->query($query);
            
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Erreur lors de la récupération des commandes : " . $e->getMessage();
        }
    }

    function deleteOrder($id) {
        $sql = "DELETE FROM orders WHERE id = :id";
        $db = DatabaseConfig::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id', $id, PDO::PARAM_INT);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    function addOrder($order) {
        $sql = "INSERT INTO orders (client_name, product, address, postal_code, phone)
                VALUES (:client_name, :product, :address, :postal_code, :phone)";
        $db = DatabaseConfig::getConnexion();
    
        try {
            $query = $db->prepare($sql);
            // Exécution de la requête avec les paramètres associés
            $query->execute([
                'client_name' => $order->getClientName(),
                'product' => $order->getProduct(),
                'address' => $order->getAddress(),
                'postal_code' => $order->getPostalCode(),
                'phone' => $order->getPhone(),
            ]);
    
            // Vérifie si l'insertion a réussi
            if ($query->rowCount() > 0) {
                // Récupération de l'ID du dernier ordre inséré
                $lastOrderId = $db->lastInsertId();
    
                // Ajouter automatiquement une livraison pour cet ordre
                $livraisonSql = "INSERT INTO livraison (idP, status) VALUES (:idP, :status)";
                $livraisonQuery = $db->prepare($livraisonSql);
                $livraisonQuery->execute([
                    'idP' => $lastOrderId, // Utilisation de l'ID de l'ordre comme idP
                    'status' => 'not yet', // Statut par défaut
                ]);
    
                // Vérifie si la livraison a été ajoutée avec succès
                if ($livraisonQuery->rowCount() > 0) {
                    return true; // Retourne true si les deux insertions ont réussi
                }
    
                return false; // Retourne false si l'ordre est ajouté mais pas la livraison
            }
    
            return false; // Si aucune ligne n'a été affectée pour l'ordre
        } catch (Exception $e) {
            // Gestion des erreurs
            echo 'Erreur lors de l\'insertion de l\'ordre ou de la livraison : ' . $e->getMessage();
            return false; // Retourne false en cas d'erreur
        }
    }
    
    

    public function updateOrder($order, $id) {
        try {
            $pdo = DatabaseConfig::getConnexion();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Activer le mode erreur
    
            // Préparer la requête SQL avec des paramètres
            $query = "UPDATE orders SET client_name = :client_name, product = :product, address = :address, postal_code = :postal_code, phone = :phone WHERE id = :id";
            $stmt = $pdo->prepare($query);
    
            // Afficher les valeurs pour le débogage
            var_dump($order->getClientName(), $order->getProduct(), $order->getAddress(), $order->getPostalCode(), $order->getPhone(), $id);
    
            // Exécuter la requête avec les valeurs de l'objet $order
            if ($stmt->execute([
                ':client_name' => $order->getClientName(),
                ':product' => $order->getProduct(),
                ':address' => $order->getAddress(),
                ':postal_code' => $order->getPostalCode(),
                ':phone' => $order->getPhone(),
                ':id' => $id
            ])) {
                echo "La mise à jour a été effectuée avec succès.";
            } else {
                echo "La mise à jour a échoué.";
            }
        } catch (Exception $e) {
            echo "Erreur lors de la mise à jour de la commande : " . $e->getMessage();
        }
    }

    public function showOrder($id) {
        $db = DatabaseConfig::getConnexion();
        $query = "SELECT * FROM orders WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    
        $orderData = $stmt->fetch(PDO::FETCH_ASSOC); // Récupérer les résultats sous forme de tableau
    
        if ($orderData) {
            // Créer un objet Order à partir du tableau
            $order = new Order(
                $orderData['id'],
                $orderData['client_name'],
                $orderData['product'],
                $orderData['address'],
                $orderData['postal_code'],
                $orderData['phone']
            );
            return $order; // Retourner l'objet Order
        }
        return null; // Si la commande n'existe pas
    }
}

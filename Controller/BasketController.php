<?php
class BasketController {
    // Create a new basket and return its ID
    public function createBasket(): int {
        $sql = "INSERT INTO basket () VALUES ()";
        $db = config::getConnexion();
        try {
            $db->exec($sql);
            return $db->lastInsertId();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Add a product to a basket
    public function addProductToBasket(int $basketId, int $productId, int $quantity): void {
        $sql = "INSERT INTO basket_products (basket_id, product_id, quantity) 
                VALUES (:basket_id, :product_id, :quantity)
                ON DUPLICATE KEY UPDATE quantity = quantity + :quantity";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'basket_id' => $basketId,
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Remove a product from a basket
    public function removeProductFromBasket(int $basketId, int $productId): void {
        $sql = "DELETE FROM basket_products WHERE basket_id = :basket_id AND product_id = :product_id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['basket_id' => $basketId, 'product_id' => $productId]);
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Retrieve basket contents
    public function getBasketContents(int $basketId): array {
        $sql = "SELECT p.*, bp.quantity 
                FROM basket_products bp
                INNER JOIN products p ON bp.product_id = p.id
                WHERE bp.basket_id = :basket_id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['basket_id' => $basketId]);
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}
?>

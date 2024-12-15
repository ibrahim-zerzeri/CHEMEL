<?php
 // Include the database configuration

include(__DIR__ . '/../Model/Basket.php');
include(__DIR__ . '/../Model/BasketProducts.php');
include(__DIR__ . '/../Controller/ProductController.php');
class BasketController {

    public function deleteBasket($id) {
        $sql = "DELETE FROM basket WHERE ID = :id";  // Ensure the correct column name
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
    
            // Check if any row was deleted
            if ($query->rowCount() > 0) {
                return true;  // Successfully deleted
            } else {
                return false; // No rows were deleted (basket not found)
            }
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    
    public function listBaskets(): array {
        $sql = "SELECT * FROM basket";  // Ensure the correct table and columns
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();
    
            // Fetch baskets as an object array
            $baskets = $query->fetchAll(PDO::FETCH_ASSOC);
    
            // Return empty array if no baskets found
            if (!$baskets) {
                return [];
            }
    
            return $baskets;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    
    // Create a new basket and return its ID
    public function createBasket(int $user_id): int {
        $sql = "INSERT INTO basket (user_id) VALUES ($user_id)";
        $db = config::getConnexion();
        try {
            $db->exec($sql);
            return $db->lastInsertId();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function getLatestBasketForUser($user_id) {
        $sql = "SELECT b.id 
                FROM basket b
                JOIN users u ON b.user_id = u.id 
                WHERE b.user_id = :user_id 
                ORDER BY b.id DESC 
                LIMIT 1";
        
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['user_id' => $user_id]);
            
            // Fetch only the 'id' column from the result
            $result = $query->fetch(PDO::FETCH_ASSOC);
            
            // Return the 'id' of the basket, or null if not found
            return $result ? $result['id'] : null;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    
    


    public function getTotalQuantity(int $basketId): int
{
    $sql = "SELECT SUM(quantity) AS total_quantity FROM basket_products where basket_id = $basketId";
    $db = config::getConnexion();
    try {
        $query = $db->prepare($sql);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        // Return the total quantity
        return $result['total_quantity'] ?? 0; // Return 0 if no result
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}
public function getProductQuantity(int $productId, int $basketId): int 
{
    $sql = "SELECT quantity FROM basket_products WHERE product_id = :product_id AND basket_id = :basket_id";
    $db = config::getConnexion();
    
    try {
        $query = $db->prepare($sql);
        // Pass both parameters together in one execute call
        $query->execute([
            'product_id' => $productId,
            'basket_id' => $basketId
        ]);
        
        $result = $query->fetch();
        
        // If no record is found, return 0
        return $result ? (int)$result['quantity'] : 0;
    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
}

   

    public function getBasketProduct()
    {
        $sql = "SELECT * FROM basket_products";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function getBasketById($user_id): ?int {
        $sql = "SELECT id 
                FROM basket 
                WHERE user_id = :user_id 
                ORDER BY id DESC 
                LIMIT 1";
        
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['user_id' => $user_id]);
            $result = $query->fetch();
            
            // Check if a result exists and return the ID, otherwise return null
            return $result ? (int) $result['id'] : null;
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
                INNER JOIN product p ON bp.product_id = p.id
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

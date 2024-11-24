<?php
include(__DIR__ . '/../config.php'); // Include the database configuration
include(__DIR__ . '/../Model/Product.php'); // Include the Product model (if using one)

class ProductController
{
    // Add a new product
    public function addProduct($product, $image)
    {
        $sql = "INSERT INTO products (PRODUCT_NAME, CATEGORY, PRICE, QUANTITY, DESCRIPTION, IMAGE_PATH) 
                VALUES (:product_name, :category, :price, :quantity, :description, :image_path)";
        $db = config::getConnexion();
        try {
            // Handle image upload
            $targetDir = "uploads/"; // Define your upload directory
            $targetFile = $targetDir . basename($image["name"]);
            move_uploaded_file($image["tmp_name"], $targetFile);

            // Prepare and execute query
            $query = $db->prepare($sql);
            $query->execute([
                'product_name' => $product->getProductName(),
                'category' => $product->getCategory(),
                'price' => $product->getPrice(),
                'quantity' => $product->getQuantity(),
                'description' => $product->getDescription(),
                'image_path' => $targetFile
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    // Update a product
    public function updateProduct($product, $id, $image = null)
    {
        $sql = "UPDATE products SET 
                    PRODUCT_NAME = :product_name,
                    CATEGORY = :category,
                    PRICE = :price,
                    QUANTITY = :quantity,
                    DESCRIPTION = :description";
        
        if ($image) {
            // Add image column if a new image is uploaded
            $sql .= ", IMAGE_PATH = :image_path";
        }
        $sql .= " WHERE ID = :id";

        $db = config::getConnexion();
        try {
            $params = [
                'id' => $id,
                'product_name' => $product->getProductName(),
                'category' => $product->getCategory(),
                'price' => $product->getPrice(),
                'quantity' => $product->getQuantity(),
                'description' => $product->getDescription()
            ];

            if ($image) {
                // Handle image upload
                $targetDir = "uploads/";
                $targetFile = $targetDir . basename($image["name"]);
                move_uploaded_file($image["tmp_name"], $targetFile);
                $params['image_path'] = $targetFile;
            }

            $query = $db->prepare($sql);
            $query->execute($params);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
?>

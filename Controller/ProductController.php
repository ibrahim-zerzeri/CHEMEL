<?php
include(__DIR__ . '/../config.php'); // Include the database configuration
include(__DIR__ . '/../Model/Product.php'); // Include the Product model (if using one)

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $productController = new ProductController();
    
    // Create a product object from the form data
    $product = new Product(
        (int)$_POST['ID'],  // Cast the ID to an integer
        $_POST['PRODUCT_NAME'], 
        $_POST['CATEGORY'], 
        (float)$_POST['PRICE'],  // Cast price to float
        (int)$_POST['QUANTITY'], // Cast quantity to integer
        $_POST['DESCRIPTION']
    );
    

    // Get the product ID from the form
    $id = $_POST['ID'];
    
    // Handle 'IS_SHOWN' checkbox (checked = 1, unchecked = 0)
    $isShown = isset($_POST['IS_SHOWN']) ? 1 : 0;

    // If an image is uploaded, process it, otherwise pass null
    if (!empty($_FILES['productImage']['name'])) {
        $image = $_FILES['productImage'];
        $productController->updateProduct($product, $id, $image, $isShown);
    } else {
        $productController->updateProduct($product, $id, null, $isShown);
    }
}
class ProductController
{

    // ProductController.php

// List filtered products based on category and search term
public function listFilteredProducts($categoryFilter = '', $searchFilter = '')
{
    $db = config::getConnexion();
    
    // Start building the SQL query
    $sql = "SELECT * FROM product WHERE 1";

    // Filter by category if specified
    if ($categoryFilter) {
        $sql .= " AND CATEGORY = :category";
    }

    // Filter by search term if specified
    if ($searchFilter) {
        $sql .= " AND PRODUCT_NAME LIKE :search";
    }

    try {
        $query = $db->prepare($sql);
        
        // Bind parameters
        if ($categoryFilter) {
            $query->bindParam(':category', $categoryFilter);
        }

        if ($searchFilter) {
            $searchTerm = "%" . $searchFilter . "%";
            $query->bindParam(':search', $searchTerm);
        }

        $query->execute();
        return $query->fetchAll();
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
        return [];
    }
}

    public function listProductsBySearch($searchTerm = '')
{
    $db = config::getConnexion();
    $sql = "SELECT * FROM product WHERE PRODUCT_NAME LIKE :searchTerm";
    $stmt = $db->prepare($sql);
    $stmt->execute(['searchTerm' => '%' . $searchTerm . '%']);
    return $stmt->fetchAll();
}

public function listCategories()
{
    $db = config::getConnexion();
    $sql = "SELECT DISTINCT CATEGORY FROM product";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
}

    // **List all products**
    public function listProducts()
    {
        $sql = "SELECT * FROM product";
        $db = config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            die('Error:' . $e->getMessage());
        }
    }

    // **Add a new product**
    public function addProduct($product, $image)
{
    $sql = "INSERT INTO product (PRODUCT_NAME, CATEGORY, PRICE, QUANTITY, DESCRIPTION, IMAGE_PATH, IS_SHOWN) 
            VALUES (:product_name, :category, :price, :quantity, :description, :image_path, :is_shown)";
    $db = config::getConnexion();
    try {
        // Ensure uploads directory exists
        $targetDir = "../uploads/"; // Relative path for storage
        $absoluteDir = __DIR__ . "/../uploads/"; // Absolute path for moving files
        
        if (!is_dir($absoluteDir)) {
            mkdir($absoluteDir, 0777, true); // Create directory if it doesn't exist
        }

        // Ensure unique file name to avoid overwriting files
        $fileName = uniqid() . '.' . pathinfo($image["name"], PATHINFO_EXTENSION); 
        $targetFile = $absoluteDir . $fileName; // Full absolute path for moving the file
        $relativePath = $targetDir . $fileName; // This is the relative path to be stored in the DB

        // Move the uploaded file to the uploads directory
        if (!move_uploaded_file($image["tmp_name"], $targetFile)) {
            throw new Exception("Failed to upload image.");
        }

        $query = $db->prepare($sql);
        $query->execute([
            'product_name' => $product->getProductName(),
            'category' => $product->getCategory(),
            'price' => $product->getPrice(),
            'quantity' => $product->getQuantity(),
            'description' => $product->getDescription(),
            'image_path' => $relativePath, // Save relative path to the image
            'is_shown' => $product->getIsShown()
        ]);
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

    

    // **Update a product**
    public function updateProduct($product, $id, $image = null, $isShown) {
        $sql = "UPDATE product SET 
                    PRODUCT_NAME = :product_name,
                    CATEGORY = :category,
                    PRICE = :price,
                    QUANTITY = :quantity,
                    DESCRIPTION = :description,
                    IS_SHOWN = :is_shown";

        if ($image) {
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
                'description' => $product->getDescription(),
                'is_shown' => $isShown
            ];

            if ($image) {
                // Handle image upload
                $targetDir = "../uploads/";
                $targetFile = $targetDir . basename($image["name"]);
                if (move_uploaded_file($image["tmp_name"], $targetFile)) {
                    $params['image_path'] =   $targetFile;
                } else {
                    throw new Exception("Failed to upload image.");
                }
            }

            $query = $db->prepare($sql);
            $query->execute($params);

            // Redirect to products page after update
            header("Location: ../View/Backoffice/products.php?success=Product Updated");
            exit();
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

/*
// Handle incoming POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'update') {
        $productController = new ProductController();
        
        $product = new Product(
            $_POST['PRODUCT_NAME'], 
            $_POST['CATEGORY'], 
            $_POST['PRICE'], 
            $_POST['QUANTITY'], 
            $_POST['DESCRIPTION']
        );

        $id = $_POST['ID'];
        $isShown = isset($_POST['IS_SHOWN']) ? $_POST['IS_SHOWN'] : 0;

        if (!empty($_FILES['productImage']['name'])) {
            $image = $_FILES['productImage'];
            $productController->updateProduct($product, $id, $image, $isShown);
        } else {
            $productController->updateProduct($product, $id, null, $isShown);
        }
    }
}*/
    // **Delete a product**
  // **Delete a product** 
public function deleteProduct($product_id)
{
    $sql = "DELETE FROM product WHERE ID = :id";
    $db = config::getConnexion();
    try {
        $query = $db->prepare($sql);
        // Use bindValue instead of bindParam to ensure it gets the value immediately
        $query->bindValue(':id', $product_id, PDO::PARAM_INT);
        
        $result = $query->execute();
        
        // Check if any rows were affected
        if ($query->rowCount() > 0) {
            return true; // Return true if the product was deleted
        } else {
            return false; // No rows were affected, which means the product wasn't found
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
        return false;
    }
}


    public function UpdateProductQuantity($product_id, $quantity) {
        $sql = "UPDATE product SET QUANTITY = :quantity WHERE ID = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindParam(':quantity', $quantity, PDO::PARAM_INT);
            $query->bindParam(':id', $product_id, PDO::PARAM_INT);
            $query->execute();
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    // **Get a single product by ID**
    public function getProductById($id)
    {
        $sql = "SELECT * FROM product WHERE ID = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
?>

<?php
// Step 1: Database Connection using PDO
$dsn = "mysql:host=localhost;dbname=chemel;charset=utf8mb4";
$username = "root";
$password = "";

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Step 2: Define Subject Class
class Subject
{
    private $id;
    private $name;
    private $image;
    private $conn;

    // Constructor
    public function __construct($conn, $id = null, $name = null, $image = null)
    {
        $this->conn = $conn;
        $this->id = $id;
        $this->name = $name;
        $this->image = $image;
    }

    // Getter and Setter for ID
    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

    // Getter and Setter for Name
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        if (empty($name)) {
            throw new Exception("Subject name is required.");
        }
        if (strlen($name) > 100) {
            throw new Exception("Subject name cannot exceed 100 characters.");
        }
        $this->name = $name;
    }

    // Getter and Setter for Image
    public function getImage()
    {
        return $this->image;
    }
    public function setImage($image)
    {
        if (empty($image)) {
            throw new Exception("Image URL is required.");
        }
        if (!filter_var($image, FILTER_VALIDATE_URL)) {
            throw new Exception("Invalid image URL format.");
        }
        if (!preg_match('/\.(jpg|png|jpeg|webp)$/i', $image)) {
            throw new Exception("Image URL must point to a valid image file (jpg, png, jpeg, webp).");
        }
        $this->image = $image;
    }

    // Fetch all subjects
    public static function fetchAll($conn)
    {
        $stmt = $conn->query("SELECT * FROM subjects");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Check for duplicate subject name
    private function isDuplicateName($name, $excludeId = null)
    {
        $sql = "SELECT COUNT(*) FROM subjects WHERE name = :name";
        if ($excludeId) {
            $sql .= " AND id != :id";
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        if ($excludeId) {
            $stmt->bindParam(':id', $excludeId);
        }
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

    // Add new subject
    public function add()
    {
        if ($this->isDuplicateName($this->name)) {
            throw new Exception("A subject with this name already exists.");
        }
        $stmt = $this->conn->prepare("INSERT INTO subjects (name, image) VALUES (:name, :image)");
        $stmt->execute([':name' => $this->name, ':image' => $this->image]);
    }

    // Update existing subject
    public function update()
    {
        if ($this->isDuplicateName($this->name, $this->id)) {
            throw new Exception("A subject with this name already exists.");
        }
        $stmt = $this->conn->prepare("UPDATE subjects SET name = :name, image = :image WHERE id = :id");
        $stmt->execute([':name' => $this->name, ':image' => $this->image, ':id' => $this->id]);
    }

    // Delete subject
    public function delete()
    {
        $stmt = $this->conn->prepare("DELETE FROM subjects WHERE id = :id");
        $stmt->execute([':id' => $this->id]);
    }
}

// Step 3: Handle Add, Edit, and Delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        if (isset($_POST['add'])) {
            // Add new subject
            $subject = new Subject($conn, null, $_POST['name'], $_POST['image']);
            $subject->add();
            echo "Subject added successfully!";
        } elseif (isset($_POST['edit'])) {
            // Edit existing subject
            $subject = new Subject($conn, $_POST['id'], $_POST['name'], $_POST['image']);
            $subject->update();
            echo "Subject updated successfully!";
        } elseif (isset($_POST['delete'])) {
            // Delete subject
            $subject = new Subject($conn, $_POST['id']);
            $subject->delete();
            echo "Subject deleted successfully!";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Step 4: Fetch existing subjects for display
$subjects = Subject::fetchAll($conn);
?>

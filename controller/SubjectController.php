<?php
class SubjectController
{
    private $conn;
    private $name;
    private $image;

    // Constructor to initialize database connection
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Setter and Getter for Name
    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    // Setter and Getter for Image
    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    // Validate Subject Name
    private function validateSubjectName($name)
    {
        // Check if the name is alphanumeric with spaces, dashes, and underscores
        // Length: Minimum 3 and maximum 50 characters
        if (preg_match("/^[a-zA-Z0-9 _-]{3,50}$/", $name)) {
            return true;
        } else {
            return false;
        }
    }

    // Add a new subject
    public function addSubject($name, $image)
    {
        if ($this->validateSubjectName($name)) {
            $this->setName($name);
            $this->setImage($image);

            $sql = "INSERT INTO subjects (name, image) VALUES (:name, :image)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':name', $this->getName());
            $stmt->bindParam(':image', $this->getImage());
            $stmt->execute();
        } else {
            // Invalid name, handle the error (e.g., throw an exception or return an error message)
            echo "Invalid subject name. Please use only alphanumeric characters, spaces, dashes, and underscores.";
        }
    }

    // Edit an existing subject
    public function editSubject($id, $name, $image)
    {
        if ($this->validateSubjectName($name)) {
            $sql = "UPDATE subjects SET name = :name, image = :image WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':image', $image);
            $stmt->execute();
        } else {
            // Invalid name, handle the error
            echo "Invalid subject name. Please use only alphanumeric characters, spaces, dashes, and underscores.";
        }
    }

    // Delete a subject
    public function deleteSubject($id)
    {
        $sql = "DELETE FROM subjects WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function getSubjectById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM subjects WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Fetch all subjects
    public function getAllSubjects()
    {
        $stmt = $this->conn->query("SELECT * FROM subjects");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch all subjects
    public function fetchAll()
    {
        $sql = "SELECT * FROM subjects";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

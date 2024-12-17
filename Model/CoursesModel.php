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

// Step 2: Define Courses Class
class Course
{
    private $id;
    private $name;
    private $pdf_file;
    private $subject_id;
    private $conn;

    // Constructor
    public function __construct($conn, $id = null, $name = null, $pdf_file = null, $subject_id = null)
    {
        $this->conn = $conn;
        $this->id = $id;
        $this->name = $name;
        $this->pdf_file = $pdf_file;
        $this->subject_id = $subject_id;
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
        $this->name = $name;
    }

    // Getter and Setter for PDF File
    public function getPdfFile()
    {
        return $this->pdf_file;
    }
    public function setPdfFile($pdf_file)
    {
        $this->pdf_file = $pdf_file;
    }

    // Getter and Setter for Subject ID
    public function getSubjectId()
    {
        return $this->subject_id;
    }
    public function setSubjectId($subject_id)
    {
        $this->subject_id = $subject_id;
    }

    // Fetch all courses
    public static function fetchAll($conn)
    {
        $stmt = $conn->query("SELECT * FROM courses");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add new course with validation
    public function handleFormSubmission()
    {
        // Validate course name
        if (empty($this->name)) {
            echo "Course name is required.";
            return;
        } elseif (strlen($this->name) < 3 || strlen($this->name) > 100) {
            echo "Course name must be between 3 and 100 characters.";
            return;
        }

        // Check if course name is unique
        if (!$this->isCourseNameUnique()) {
            echo "Course name is already taken.";
            return;
        }

        // Validate subject ID
        if (!$this->isSubjectValid()) {
            echo "Invalid subject ID.";
            return;
        }

        // Handle PDF file upload and validation
        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === 0) {
            $this->pdf_file = $this->handleFileUpload();
        }

        // Add the course to the database
        $stmt = $this->conn->prepare("INSERT INTO courses (name, pdf_file, subject_id) VALUES (:name, :pdf_file, :subject_id)");
        $stmt->execute([':name' => $this->name, ':pdf_file' => $this->pdf_file, ':subject_id' => $this->subject_id]);
    }

    // Check if the course name is unique
    private function isCourseNameUnique()
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM courses WHERE name = :name");
        $stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() == 0;
    }

    // Validate subject ID exists in the subjects table
    private function isSubjectValid()
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM subjects WHERE id = :subject_id");
        $stmt->bindParam(':subject_id', $this->subject_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0; // Returns true if subject exists
    }

    // Handle file upload for PDF files
    private function handleFileUpload()
    {
        $pdf_file = $_FILES['pdf_file'];
        $pdf_file_name = basename($pdf_file['name']);
        $pdf_file_tmp = $pdf_file['tmp_name'];
        $pdf_file_size = $pdf_file['size'];
        $allowed_exts = ['pdf'];
        $file_ext = pathinfo($pdf_file_name, PATHINFO_EXTENSION);

        if (!in_array($file_ext, $allowed_exts)) {
            echo "Invalid file type. Only PDF files are allowed.";
            exit;
        }

        if ($pdf_file_size > 10485760) {  // 10MB max size
            echo "PDF file size exceeds the maximum allowed size of 10MB.";
            exit;
        }

        // Clean up course name for filename
        $course_name_clean = preg_replace('/[^a-zA-Z0-9-_]/', '_', $this->name);
        $new_pdf_file_name = $course_name_clean . '.' . $file_ext;
        $pdf_file_path = 'uploads/' . $new_pdf_file_name;

        if (!is_dir('uploads')) {
            mkdir('uploads', 0755, true);
        }

        move_uploaded_file($pdf_file_tmp, $pdf_file_path);
        return $pdf_file_path;
    }

    // Update existing course with validation
    public function update()
    {
        // Validate course name
        if (empty($this->name)) {
            echo "Course name is required.";
            return;
        } elseif (strlen($this->name) < 3 || strlen($this->name) > 100) {
            echo "Course name must be between 3 and 100 characters.";
            return;
        }

        // Check if course name is unique
        if (!$this->isCourseNameUnique()) {
            echo "Course name is already taken.";
            return;
        }

        // Validate subject ID
        if (!$this->isSubjectValid()) {
            echo "Invalid subject ID.";
            return;
        }

        // Handle PDF file upload if new file is provided
        if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === 0) {
            $this->pdf_file = $this->handleFileUpload();
        }

        // Update the course in the database
        $stmt = $this->conn->prepare("UPDATE courses SET name = :name, pdf_file = :pdf_file, subject_id = :subject_id WHERE id = :id");
        $stmt->execute([
            ':name' => $this->name,
            ':pdf_file' => $this->pdf_file,
            ':subject_id' => $this->subject_id,
            ':id' => $this->id
        ]);
    }

    // Delete course
    public function delete()
    {
        // Fetch the existing file path
        $stmt = $this->conn->prepare("SELECT pdf_file FROM courses WHERE id = :id");
        $stmt->execute([':id' => $this->id]);
        $course = $stmt->fetch(PDO::FETCH_ASSOC);

        // If the course exists and has a file, delete it
        if ($course && file_exists($course['pdf_file'])) {
            unlink($course['pdf_file']); // Delete the file
        }

        // Delete course from the database
        $stmt = $this->conn->prepare("DELETE FROM courses WHERE id = :id");
        $stmt->execute([':id' => $this->id]);
    }

    // Fetch course by ID
    public static function fetchById($conn, $id)
    {
        $stmt = $conn->prepare("SELECT * FROM courses WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// Step 3: Handle Add, Edit, and Delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add'])) {
        // Add new course
        $course = new Course($conn, null, $_POST['name'], $_POST['pdf_file'], $_POST['subject_id']);
        $course->handleFormSubmission();
    } elseif (isset($_POST['edit'])) {
        // Edit existing course
        $course = new Course($conn, $_POST['id'], $_POST['name'], $_POST['pdf_file'], $_POST['subject_id']);
        $course->update();
    } elseif (isset($_POST['delete'])) {
        // Delete course
        $course = new Course($conn, $_POST['id']);
        $course->delete();
    }
}

// Step 4: Fetch existing courses for display
$courses = Course::fetchAll($conn);
?>

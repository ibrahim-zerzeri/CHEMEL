<?php
class CourseController
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // Validation for the course name
    public function validateCourseName($name)
    {
        // Trim whitespace
        $name = trim($name);
        
        // Check for minimum and maximum length
        if (strlen($name) < 3 || strlen($name) > 100) {
            return "Course name must be between 3 and 100 characters.";
        }

        // Regex to allow letters, numbers, spaces, dashes, and underscores
        if (!preg_match('/^[a-zA-Z0-9\s_-]+$/', $name)) {
            return "Course name can only contain letters, numbers, spaces, dashes (-), and underscores (_).";
        }

        return true; // Validation passed
    }

    // Handle form submission for adding/editing course
    public function handleFormSubmission($name, $pdf_file = null, $subject_id, $course_id = null)
    {
        // Validate course name
        $courseNameValidation = $this->validateCourseName($name);
        if ($courseNameValidation !== true) {
            return $courseNameValidation;  // Return the error message if validation fails
        }

        // If a PDF file is provided, handle file upload
        if ($pdf_file) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($pdf_file["name"]);
            if (move_uploaded_file($pdf_file["tmp_name"], $target_file)) {
                $pdf_file_path = $target_file;
            } else {
                return "There was an error uploading the file.";
            }
        } else {
            $pdf_file_path = null;  // No file uploaded
        }

        // Add or update course in the database
        if ($course_id) {
            // Update course
            $stmt = $this->conn->prepare("UPDATE courses SET name = ?, pdf_file = ?, subject_id = ? WHERE id = ?");
            $stmt->execute([$name, $pdf_file_path, $subject_id, $course_id]);
        } else {
            // Add new course
            $stmt = $this->conn->prepare("INSERT INTO courses (name, pdf_file, subject_id) VALUES (?, ?, ?)");
            $stmt->execute([$name, $pdf_file_path, $subject_id]);
        }

        return true;  // Success
    }

    // Handle deleting a course
    public function handleDelete($course_id)
    {
        $stmt = $this->conn->prepare("DELETE FROM courses WHERE id = ?");
        $stmt->execute([$course_id]);
    }

    // Get all courses
    public function getCourses()
    {
        $stmt = $this->conn->query("SELECT * FROM courses");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a course by ID
    public function getCourseById($course_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM courses WHERE id = ?");
        $stmt->execute([$course_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get all subjects for the dropdown
    public function getSubjects()
    {
        $stmt = $this->conn->query("SELECT * FROM subjects");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get a subject by ID
    public function getSubjectById($subject_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM subjects WHERE id = ?");
        $stmt->execute([$subject_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

?php
namespace App\Models; // Add the namespace to avoid class conflicts.

class CoursedetModel {
    private $conn;
    private $table_name = "coursedet";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Fetch course details based on coursedet_id
    public function getCoursedetDetails($coursedet_id) {
        // Adjust query to fetch details from the courses and coursedet tables
        $query = "SELECT c.id AS course_id, c.name AS course_name, c.pdf_file_path, 
                         cd.description AS coursedet_description, cd.subject AS coursedet_subject
                  FROM courses c
                  LEFT JOIN coursedet cd ON c.id = cd.course_id
                  WHERE cd.id = :coursedet_id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':coursedet_id', $coursedet_id);
        $stmt->execute();

        // Return the data as an associative array
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

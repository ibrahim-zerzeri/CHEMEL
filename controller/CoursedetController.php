?php
// Ensure the path to the model is correct
include_once '../model/CoursedetModel.php'; // Include the model from the correct relative path

class CoursedetController {
    private $coursedetModel;

    public function __construct($db) {
        // Instantiate the model
        $this->coursedetModel = new CoursedetModel($db);
    }

    // Fetch course details using the model
    public function getCourseDetails($coursedet_id) {
        return $this->coursedetModel->getCoursedetDetails($coursedet_id);
    }
}
?>

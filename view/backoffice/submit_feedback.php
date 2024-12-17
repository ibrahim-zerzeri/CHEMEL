<?php
// Database connection parameters
$dsn = "mysql:host=localhost;dbname=chemel;charset=utf8mb4";
$username = "root";
$password = "";

try {
    // Establish a PDO connection to the database
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if feedback is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['feedback'], $_POST['course_id'])) {
    $feedback = $_POST['feedback'];
    $course_id = $_POST['course_id'];

    // Prepare SQL query to insert feedback
    $query = "INSERT INTO feedbacks (course_id, feedback_text) VALUES (:course_id, :feedback_text)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
    $stmt->bindParam(':feedback_text', $feedback, PDO::PARAM_STR);

    // Execute the query and handle errors
    try {
        $stmt->execute();
        header("Location: course_details.php?id=" . $course_id . "&feedback_success=1"); // Redirect to course page with success message
    } catch (PDOException $e) {
        // Handle error if query fails
        echo "Error submitting feedback: " . $e->getMessage();
    }
} else {
    echo "Error: Feedback or course ID is missing.";
}
?>

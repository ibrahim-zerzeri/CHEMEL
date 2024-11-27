<?php
class Config
{
    private static $pdo = null;

    public static function getConnexion()
    {
        if (!isset(self::$pdo)) {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "chemel";

            try {
                self::$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                die('Erreur: ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}

$conn = Config::getConnexion();
// Assuming $course_id is already set from the URL parameter
$course_id = isset($_GET['id']) ? intval($_GET['id']) : 0; // Get the course ID from URL

if ($course_id > 0) {
    // Prepare SQL query to fetch the course details including the PDF file path
    $stmt = $conn->prepare("SELECT * FROM courses WHERE id = :course_id");
    $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the course details
    $course = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($course) {
        // Extract PDF file path from the database
        $pdf_file_name = $course['pdf_file']; // Assuming 'pdf_file' is the column in the DB
        $pdf_file_path = 'C:\xampp\htdocs\chemel\view\chemel_back\uploads' . $pdf_file_name; // Construct the full path
        echo "PDF Path: " . htmlspecialchars($pdf_file_path);

    } else {
        echo "Course not found.";
        exit;
    }
} else {
    echo "Invalid course ID.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">

    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.css">
    
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">

    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/ionicons.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/jquery.timepicker.css">

    
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/icomoon.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Course Details</h1>

        <!-- Course Name -->
        <h2><?= htmlspecialchars($course['name']); ?></h2>

        <!-- Course Subject (Fetch subject name) -->
        <?php
        $subject_stmt = $conn->prepare("SELECT name FROM subjects WHERE id = :id");
        $subject_stmt->execute([':id' => $course['subject_id']]);
        $subject = $subject_stmt->fetch();
        ?>
        <p><strong>Subject:</strong> <?= htmlspecialchars($subject['name']); ?></p>

        <!-- Embed PDF File -->
        <p><strong>PDF File:</strong></p>
        <iframe src="<?= htmlspecialchars($pdf_file_path); ?>" width="100%" height="600px"></iframe>

        <!-- Chatbot Section -->
        <div class="my-4">
            <h3>Chat with us</h3>
            <div style="width: 5cm; height: 5cm; border: 1px solid #ccc; padding: 10px;">
                <!-- Simulate a Chatbot in a 5x5 cm box -->
                <p>Welcome to the course support! How can I assist you?</p>
            </div>
            <button class="btn btn-primary mt-2">Start Chat</button>
            <a class="btn btn-primary" href="quiz.php?id=<?= htmlspecialchars($course['id']); ?>">Go to Quiz</a>
        </div>
    </div>


    <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


<script src="js/jquery.min.js"></script>
<script src="js/jquery-migrate-3.0.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/jquery.waypoints.min.js"></script>
<script src="js/jquery.stellar.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/aos.js"></script>
<script src="js/jquery.animateNumber.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/scrollax.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
<script src="js/google-map.js"></script>
<script src="js/main.js"></script>
</body>
</html>

<?php
include '../../controller/CoursesController.php';

// Database connection
$dsn = "mysql:host=localhost;dbname=chemel;charset=utf8mb4";
$username = "root";
$password = "";

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Instantiate controller
$courseController = new CourseController($conn);

// Step 2: Handle Add, Edit, and Delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $name = $_POST['name'];
        $pdf_file = $_FILES['pdf_file'] ?? null;
        $subject_id = $_POST['subject_id'];
        $course_id = $_POST['id'] ?? null; // For edit action

        $validationResult = $courseController->handleFormSubmission($name, $pdf_file, $subject_id, $course_id);
        
        if ($validationResult !== true) {
            $error_message = $validationResult;  // Show validation error
        } else {
            header('Location: courses.php'); // Redirect after action
            exit;
        }
    }
}

// Check for delete action in GET request
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $course_id = $_GET['id'];
    $courseController->handleDelete($course_id);
    header('Location: courses.php'); // Redirect after delete
    exit;
}

// Fetch existing courses for display
$courses = $courseController->getCourses();

// Handle editing a course
$course_to_edit = null;
if (isset($_GET['edit'])) {
    $course_id = (int) $_GET['edit'];
    $course_to_edit = $courseController->getCourseById($course_id);

    // Check if the course exists
    if (!$course_to_edit) {
        echo "Course not found.";
        exit;
    }
}

// Fetch subjects for the dropdown
$subjects = $courseController->getSubjects();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Manage Courses</title>
    <link rel="stylesheet" href="./assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="./assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/libs/css/style.css">
    <link rel="stylesheet" href="./assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
</head>
<body>
    <div class="dashboard-main-wrapper">
        <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="../index.html">Concept</a>
            </nav>
        </div>

        <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="courses.php">Courses</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>

        <div class="dashboard-wrapper">
            <div class="container-fluid">
                <div class="content">
                    <h1 class="my-4">Manage Courses</h1>

                    <!-- Show error feedback if validation fails -->
                    <?php if (isset($error_message)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error_message); ?></div>
                    <?php endif; ?>

                    <!-- Add/Edit Course Form -->
                    <form method="POST" enctype="multipart/form-data" class="mb-4">
                        <input type="hidden" name="action" value="<?= $course_to_edit ? 'edit' : 'add'; ?>">
                        <?php if ($course_to_edit): ?>
                            <input type="hidden" name="id" value="<?= $course_to_edit['id']; ?>">
                            <input type="hidden" name="existing_pdf" value="<?= $course_to_edit['pdf_file']; ?>">
                        <?php endif; ?>

                        <div class="form-group">
                            <label for="name">Course Name</label>
                            <input type="text" name="name" id="name" class="form-control" 
                                value="<?= $course_to_edit ? htmlspecialchars($course_to_edit['name']) : ''; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="subject_id">Subject</label>
                            <select name="subject_id" id="subject_id" class="form-control" required>
                                <option value="">Select Subject</option>
                                <?php foreach ($subjects as $subject): ?>
                                    <option value="<?= $subject['id']; ?>" 
                                        <?= $course_to_edit && $subject['id'] == $course_to_edit['subject_id'] ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($subject['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="pdf_file">PDF File <?= $course_to_edit ? '(Optional)' : ''; ?></label>
                            <input type="file" name="pdf_file" id="pdf_file" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <?= $course_to_edit ? 'Update Course' : 'Add Course'; ?>
                        </button>
                    </form>

                    <h2 class="my-4">Existing Courses</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Course Name</th>
                                <th>Subject</th>
                                <th>PDF File</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($courses as $course): ?>
                                <tr>
                                    <td><?= htmlspecialchars($course['name']); ?></td>
                                    <td>
                                        <?php
                                        $subject = $courseController->getSubjectById($course['subject_id']);
                                        if ($subject) {
                                            echo htmlspecialchars($subject['name']);
                                        } else {
                                            echo "No Subject Found";
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="<?= htmlspecialchars($course['pdf_file']); ?>" target="_blank">Download</a>
                                    </td>
                                    <td>
                                        <a href="?edit=<?= $course['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <a href="?action=delete&id=<?= $course['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this course?')">Delete</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>

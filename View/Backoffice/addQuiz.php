<?php
include_once '../../config.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_id = $_POST['course_id'];
    $subject_id = $_POST['subject_id'];
    $question = $_POST['question'];
    $option_a = $_POST['option_a'];
    $option_b = $_POST['option_b'];
    $option_c = $_POST['option_c'];
    $option_d = $_POST['option_d'];
    $correct_option = $_POST['correct_option'];

    // Validate inputs
    // Check if the question ends with a "?"
    if (substr($question, -1) !== '?') {
        $errors['question'] = "The question must end with a '?'.";
    }

    // Check if options end with "."
    $options = ['option_a', 'option_b', 'option_c', 'option_d'];
    foreach ($options as $option) {
        if (substr($$option, -1) !== '.') {
            $errors[$option] = ucfirst(str_replace('_', ' ', $option)) . " must end with a '.'.";
        }
    }

    // Check if the correct option is one of the valid options (A, B, C, D)
    if (!in_array($correct_option, ['A', 'B', 'C', 'D'])) {
        $errors['correct_option'] = "Correct option must be one of the letters A, B, C, or D.";
    }

    // If there are validation errors, show them
    if (empty($errors)) {
        // No errors, proceed with DB insertion
        $conn = config::getConnexion();

        $sql = "INSERT INTO quizzes (course_id, subject_id, question, option_a, option_b, option_c, option_d, correct_option)
                VALUES (:course_id, :subject_id, :question, :option_a, :option_b, :option_c, :option_d, :correct_option)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
        $stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
        $stmt->bindParam(':question', $question, PDO::PARAM_STR);
        $stmt->bindParam(':option_a', $option_a, PDO::PARAM_STR);
        $stmt->bindParam(':option_b', $option_b, PDO::PARAM_STR);
        $stmt->bindParam(':option_c', $option_c, PDO::PARAM_STR);
        $stmt->bindParam(':option_d', $option_d, PDO::PARAM_STR);
        $stmt->bindParam(':correct_option', $correct_option, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "<script>alert('Quiz added successfully!'); window.location.href='ManageQuiz.php';</script>";
        } else {
            echo "<script>alert('Error: Could not add quiz.'); window.location.href='ManageQuiz.php';</script>";
        }
    }
}

// Fetch courses and subjects
$conn = config::getConnexion();
$query_courses = "SELECT * FROM courses";
$stmt_courses = $conn->prepare($query_courses);
$stmt_courses->execute();
$courses = $stmt_courses->fetchAll();

$query_subjects = "SELECT * FROM subjects";
$stmt_subjects = $conn->prepare($query_subjects);
$stmt_subjects->execute();
$subjects = $stmt_subjects->fetchAll();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Quiz Management</title>
    <link rel="stylesheet" href="./assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="./assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/libs/css/style.css">
    <link rel="stylesheet" href="./assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
</head>

<body>
    <div class="dashboard-main-wrapper">
        <!-- Navbar and Sidebar here -->

        <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">Add Quiz</h2>
                            <p class="pageheader-text">Add a new quiz by filling in the form below.</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Add Quiz</h5>
                            <div class="card-body">
                                <form method="POST" action="addQuiz.php">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="course_id">Course</label>
                                            <select class="form-control" id="course_id" name="course_id" required>
                                                <option value="">Select Course</option>
                                                <?php foreach ($courses as $course): ?>
                                                    <option value="<?= $course['id']; ?>" <?= (isset($course_id) && $course_id == $course['id']) ? 'selected' : ''; ?>><?= $course['name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php if (isset($errors['course_id'])): ?>
                                                <div class="text-danger"><?= $errors['course_id']; ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="subject_id">Subject</label>
                                            <select class="form-control" id="subject_id" name="subject_id" required>
                                                <option value="">Select Subject</option>
                                                <?php foreach ($subjects as $subject): ?>
                                                    <option value="<?= $subject['id']; ?>" <?= (isset($subject_id) && $subject_id == $subject['id']) ? 'selected' : ''; ?>><?= $subject['name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php if (isset($errors['subject_id'])): ?>
                                                <div class="text-danger"><?= $errors['subject_id']; ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="question">Question</label>
                                        <textarea class="form-control" id="question" name="question" rows="2" required><?= isset($question) ? $question : ''; ?></textarea>
                                        <?php if (isset($errors['question'])): ?>
                                            <div class="text-danger"><?= $errors['question']; ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="option_a">Option A</label>
                                        <input type="text" class="form-control" id="option_a" name="option_a" required value="<?= isset($option_a) ? $option_a : ''; ?>">
                                        <?php if (isset($errors['option_a'])): ?>
                                            <div class="text-danger"><?= $errors['option_a']; ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="option_b">Option B</label>
                                        <input type="text" class="form-control" id="option_b" name="option_b" required value="<?= isset($option_b) ? $option_b : ''; ?>">
                                        <?php if (isset($errors['option_b'])): ?>
                                            <div class="text-danger"><?= $errors['option_b']; ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="option_c">Option C</label>
                                        <input type="text" class="form-control" id="option_c" name="option_c" required value="<?= isset($option_c) ? $option_c : ''; ?>">
                                        <?php if (isset($errors['option_c'])): ?>
                                            <div class="text-danger"><?= $errors['option_c']; ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="option_d">Option D</label>
                                        <input type="text" class="form-control" id="option_d" name="option_d" required value="<?= isset($option_d) ? $option_d : ''; ?>">
                                        <?php if (isset($errors['option_d'])): ?>
                                            <div class="text-danger"><?= $errors['option_d']; ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <label for="correct_option">Correct Option</label>
                                        <input type="text" class="form-control" id="correct_option" name="correct_option" required value="<?= isset($correct_option) ? $correct_option : ''; ?>">
                                        <?php if (isset($errors['correct_option'])): ?>
                                            <div class="text-danger"><?= $errors['correct_option']; ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Add Quiz</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="./assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="./assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>

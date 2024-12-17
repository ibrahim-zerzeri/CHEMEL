<?php
include('./../../config.php');

// Initialize an array to hold error messages
$errors = [];

// Fetch quiz details if an ID is passed
if (isset($_GET['id'])) {
    $quiz_id = $_GET['id'];

    $conn = config::getConnexion();
    $sql = "SELECT * FROM quizzes WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $quiz_id, PDO::PARAM_INT);
    $stmt->execute();
    $quiz = $stmt->fetch();
} else {
    header("Location: ManageQuiz.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $course_id = $_POST['COURSE_ID'];
    $subject_id = $_POST['SUBJECT_ID'];
    $question = $_POST['QUESTION'];
    $option_a = $_POST['OPTION_A'];
    $option_b = $_POST['OPTION_B'];
    $option_c = $_POST['OPTION_C'];
    $option_d = $_POST['OPTION_D'];
    $correct_option = $_POST['CORRECT_OPTION'];
    $level = $_POST['LEVEL'];  // Added level field

    // Validation for each field
    if (empty($course_id)) {
        $errors['course_id'] = "Course ID is required.";
    }
    if (empty($subject_id)) {
        $errors['subject_id'] = "Subject ID is required.";
    }
    if (empty($question)) {
        $errors['question'] = "Question is required.";
    } elseif (substr($question, -1) !== '?') {
        $errors['question'] = "Question must end with a question mark (?).";
    }
    if (empty($option_a)) {
        $errors['option_a'] = "Option A is required.";
    } elseif (substr($option_a, -1) !== '.') {
        $errors['option_a'] = "Option A must end with a period (.)";
    }
    if (empty($option_b)) {
        $errors['option_b'] = "Option B is required.";
    } elseif (substr($option_b, -1) !== '.') {
        $errors['option_b'] = "Option B must end with a period (.)";
    }
    if (empty($option_c)) {
        $errors['option_c'] = "Option C is required.";
    } elseif (substr($option_c, -1) !== '.') {
        $errors['option_c'] = "Option C must end with a period (.)";
    }
    if (empty($option_d)) {
        $errors['option_d'] = "Option D is required.";
    } elseif (substr($option_d, -1) !== '.') {
        $errors['option_d'] = "Option D must end with a period (.)";
    }
    if (empty($correct_option)) {
        $errors['correct_option'] = "Correct Option is required.";
    } elseif (!in_array(strtoupper($correct_option), ['A', 'B', 'C', 'D'])) {
        $errors['correct_option'] = "Correct Option must be one of the following: A, B, C, or D.";
    }
    if (empty($level)) {
        $errors['level'] = "Level is required.";
    } elseif (!in_array($level, [1, 2, 3])) {
        $errors['level'] = "Level must be 1, 2, or 3.";
    }

    // If there are no errors, update the quiz in the database
    if (empty($errors)) {
        $update_sql = "
            UPDATE quizzes 
            SET course_id = :course_id, subject_id = :subject_id, question = :question, 
                option_a = :option_a, option_b = :option_b, option_c = :option_c, 
                option_d = :option_d, correct_option = :correct_option, level = :level
            WHERE id = :id";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
        $update_stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
        $update_stmt->bindParam(':question', $question, PDO::PARAM_STR);
        $update_stmt->bindParam(':option_a', $option_a, PDO::PARAM_STR);
        $update_stmt->bindParam(':option_b', $option_b, PDO::PARAM_STR);
        $update_stmt->bindParam(':option_c', $option_c, PDO::PARAM_STR);
        $update_stmt->bindParam(':option_d', $option_d, PDO::PARAM_STR);
        $update_stmt->bindParam(':correct_option', $correct_option, PDO::PARAM_STR);
        $update_stmt->bindParam(':level', $level, PDO::PARAM_INT);  // Bind level
        $update_stmt->bindParam(':id', $quiz_id, PDO::PARAM_INT);

        if ($update_stmt->execute()) {
            echo "<script>alert('Quiz updated successfully!'); window.location.href='ManageQuiz.php';</script>";
        } else {
            echo "Error: " . $update_stmt->errorInfo()[2];
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Quiz</title>
    <link rel="stylesheet" href="./assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/libs/css/style.css">
</head>
<body>
    <div class="dashboard-main-wrapper">
        <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">Edit Quiz</h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header">Edit Quiz Details</h5>
                            <div class="card-body">
                                <form method="POST" action="">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="editCourseId">Course ID</label>
                                            <input type="number" class="form-control" id="editCourseId" name="COURSE_ID" value="<?php echo htmlspecialchars($quiz['course_id']); ?>" required>
                                            <?php if (isset($errors['course_id'])): ?>
                                                <div class="text-danger"><?php echo $errors['course_id']; ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="editSubjectId">Subject ID</label>
                                            <input type="number" class="form-control" id="editSubjectId" name="SUBJECT_ID" value="<?php echo htmlspecialchars($quiz['subject_id']); ?>" required>
                                            <?php if (isset($errors['subject_id'])): ?>
                                                <div class="text-danger"><?php echo $errors['subject_id']; ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="editQuestion">Question</label>
                                        <textarea class="form-control" id="editQuestion" name="QUESTION" rows="3" required><?php echo htmlspecialchars($quiz['question']); ?></textarea>
                                        <?php if (isset($errors['question'])): ?>
                                            <div class="text-danger"><?php echo $errors['question']; ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="editOptionA">Option A</label>
                                            <input type="text" class="form-control" id="editOptionA" name="OPTION_A" value="<?php echo htmlspecialchars($quiz['option_a']); ?>" required>
                                            <?php if (isset($errors['option_a'])): ?>
                                                <div class="text-danger"><?php echo $errors['option_a']; ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="editOptionB">Option B</label>
                                            <input type="text" class="form-control" id="editOptionB" name="OPTION_B" value="<?php echo htmlspecialchars($quiz['option_b']); ?>" required>
                                            <?php if (isset($errors['option_b'])): ?>
                                                <div class="text-danger"><?php echo $errors['option_b']; ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="editOptionC">Option C</label>
                                            <input type="text" class="form-control" id="editOptionC" name="OPTION_C" value="<?php echo htmlspecialchars($quiz['option_c']); ?>" required>
                                            <?php if (isset($errors['option_c'])): ?>
                                                <div class="text-danger"><?php echo $errors['option_c']; ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="editOptionD">Option D</label>
                                            <input type="text" class="form-control" id="editOptionD" name="OPTION_D" value="<?php echo htmlspecialchars($quiz['option_d']); ?>" required>
                                            <?php if (isset($errors['option_d'])): ?>
                                                <div class="text-danger"><?php echo $errors['option_d']; ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="editCorrectOption">Correct Option</label>
                                        <input type="text" class="form-control" id="editCorrectOption" name="CORRECT_OPTION" value="<?php echo htmlspecialchars($quiz['correct_option']); ?>" required>
                                        <?php if (isset($errors['correct_option'])): ?>
                                            <div class="text-danger"><?php echo $errors['correct_option']; ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Level Dropdown -->
                                    <div class="form-group">
                                        <label for="editLevel">Level</label>
                                        <select class="form-control" id="editLevel" name="LEVEL" required>
                                            <option value="1" <?php echo ($quiz['level'] == 1) ? 'selected' : ''; ?>>1</option>
                                            <option value="2" <?php echo ($quiz['level'] == 2) ? 'selected' : ''; ?>>2</option>
                                            <option value="3" <?php echo ($quiz['level'] == 3) ? 'selected' : ''; ?>>3</option>
                                        </select>
                                        <?php if (isset($errors['level'])): ?>
                                            <div class="text-danger"><?php echo $errors['level']; ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="./assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="./assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>

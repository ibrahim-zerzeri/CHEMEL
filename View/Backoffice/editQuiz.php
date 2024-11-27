<?php
include('./../../config.php');

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
    $course_id = $_POST['COURSE_ID'];
    $subject_id = $_POST['SUBJECT_ID'];
    $question = $_POST['QUESTION'];
    $option_a = $_POST['OPTION_A'];
    $option_b = $_POST['OPTION_B'];
    $option_c = $_POST['OPTION_C'];
    $option_d = $_POST['OPTION_D'];
    $correct_option = $_POST['CORRECT_OPTION'];

    
    $update_sql = "
        UPDATE quizzes 
        SET course_id = :course_id, subject_id = :subject_id, question = :question, 
            option_a = :option_a, option_b = :option_b, option_c = :option_c, 
            option_d = :option_d, correct_option = :correct_option 
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
    $update_stmt->bindParam(':id', $quiz_id, PDO::PARAM_INT);

    if ($update_stmt->execute()) {
        echo "<script>alert('Quiz updated successfully!'); window.location.href='ManageQuiz.php';</script>";
    } else {
        echo "Error: " . $update_stmt->errorInfo()[2];
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
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="editSubjectId">Subject ID</label>
                                            <input type="number" class="form-control" id="editSubjectId" name="SUBJECT_ID" value="<?php echo htmlspecialchars($quiz['subject_id']); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="editQuestion">Question</label>
                                        <textarea class="form-control" id="editQuestion" name="QUESTION" rows="3" required><?php echo htmlspecialchars($quiz['question']); ?></textarea>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="editOptionA">Option A</label>
                                            <input type="text" class="form-control" id="editOptionA" name="OPTION_A" value="<?php echo htmlspecialchars($quiz['option_a']); ?>" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="editOptionB">Option B</label>
                                            <input type="text" class="form-control" id="editOptionB" name="OPTION_B" value="<?php echo htmlspecialchars($quiz['option_b']); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="editOptionC">Option C</label>
                                            <input type="text" class="form-control" id="editOptionC" name="OPTION_C" value="<?php echo htmlspecialchars($quiz['option_c']); ?>" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="editOptionD">Option D</label>
                                            <input type="text" class="form-control" id="editOptionD" name="OPTION_D" value="<?php echo htmlspecialchars($quiz['option_d']); ?>" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="editCorrectOption">Correct Option</label>
                                        <input type="text" class="form-control" id="editCorrectOption" name="CORRECT_OPTION" value="<?php echo htmlspecialchars($quiz['correct_option']); ?>" required>
                                    </div>
                                    <p><a href="ManageQuiz.php" class="text-secondary">Back to quizzes</a></p>
                                    <button type="submit" class="btn btn-primary">Update Quiz</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
</body>
</html>

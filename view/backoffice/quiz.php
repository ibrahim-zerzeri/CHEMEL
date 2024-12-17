<?php
// Step 1: Connect to the Database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "chemel"; // Database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Add/Edit Quiz Logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Add new quiz
    if (isset($_POST['add_quiz'])) {
        $course_id = $_POST['course_id'];
        $question = $_POST['question'];
        $option_a = $_POST['option_a'];
        $option_b = $_POST['option_b'];
        $option_c = $_POST['option_c'];
        $option_d = $_POST['option_d'];
        $correct_option = $_POST['correct_option'];

        // Insert quiz into the database
        $sql = "INSERT INTO quizzes (course_id, question, option_a, option_b, option_c, option_d, correct_option)
                VALUES ('$course_id', '$question', '$option_a', '$option_b', '$option_c', '$option_d', '$correct_option')";

        if ($conn->query($sql) === TRUE) {
            echo "New quiz added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Edit quiz
    if (isset($_POST['edit_quiz'])) {
        $quiz_id = $_POST['quiz_id'];
        $course_id = $_POST['course_id'];
        $question = $_POST['question'];
        $option_a = $_POST['option_a'];
        $option_b = $_POST['option_b'];
        $option_c = $_POST['option_c'];
        $option_d = $_POST['option_d'];
        $correct_option = $_POST['correct_option'];

        // Update quiz in the database
        $sql = "UPDATE quizzes SET course_id='$course_id', question='$question', option_a='$option_a', option_b='$option_b', 
                option_c='$option_c', option_d='$option_d', correct_option='$correct_option' WHERE id='$quiz_id'";

        if ($conn->query($sql) === TRUE) {
            echo "Quiz updated successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Delete quiz
    if (isset($_POST['delete_quiz'])) {
        $quiz_id = $_POST['quiz_id'];

        // Delete quiz from the database
        $sql = "DELETE FROM quizzes WHERE id='$quiz_id'";

        if ($conn->query($sql) === TRUE) {
            echo "Quiz deleted successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

// Step 3: Fetch quiz data for editing
$quiz_data = null;
if (isset($_GET['edit'])) {
    $quiz_id = $_GET['edit'];
    $quiz_result = $conn->query("SELECT * FROM quizzes WHERE id='$quiz_id'");

    if ($quiz_result->num_rows > 0) {
        $quiz_data = $quiz_result->fetch_assoc();
    }
}

// Step 4: Fetch existing quizzes
$sql = "SELECT * FROM quizzes";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Quizzes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Manage Quizzes</h2>

    <!-- Add/Edit Quiz Form -->
    <form method="POST" action="">
        <h4 class="mt-4"><?= isset($quiz_data) ? 'Edit Quiz' : 'Add Quiz' ?></h4>
        <div class="form-group">
            <label for="course_id">Course ID</label>
            <select class="form-control" name="course_id" id="course_id" required>
                <?php
                $courses_result = $conn->query("SELECT * FROM courses");
                while ($course = $courses_result->fetch_assoc()) {
                    $selected = isset($quiz_data) && $quiz_data['course_id'] == $course['id'] ? 'selected' : '';
                    echo "<option value='" . $course['id'] . "' $selected>" . $course['name'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="question">Question</label>
            <input type="text" class="form-control" name="question" id="question" value="<?= isset($quiz_data) ? $quiz_data['question'] : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="option_a">Option A</label>
            <input type="text" class="form-control" name="option_a" id="option_a" value="<?= isset($quiz_data) ? $quiz_data['option_a'] : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="option_b">Option B</label>
            <input type="text" class="form-control" name="option_b" id="option_b" value="<?= isset($quiz_data) ? $quiz_data['option_b'] : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="option_c">Option C</label>
            <input type="text" class="form-control" name="option_c" id="option_c" value="<?= isset($quiz_data) ? $quiz_data['option_c'] : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="option_d">Option D</label>
            <input type="text" class="form-control" name="option_d" id="option_d" value="<?= isset($quiz_data) ? $quiz_data['option_d'] : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="correct_option">Correct Option</label>
            <input type="text" class="form-control" name="correct_option" id="correct_option" value="<?= isset($quiz_data) ? $quiz_data['correct_option'] : '' ?>" required>
        </div>

        <!-- Add or Edit Quiz Button -->
        <button type="submit" name="<?= isset($quiz_data) ? 'edit_quiz' : 'add_quiz' ?>" class="btn btn-primary"><?= isset($quiz_data) ? 'Edit Quiz' : 'Add Quiz' ?></button>

        <!-- Hidden Field for Editing -->
        <input type="hidden" name="quiz_id" value="<?= isset($quiz_data) ? $quiz_data['id'] : '' ?>">
    </form>

    <!-- Quizzes Table -->
    <h4 class="mt-5">Existing Quizzes</h4>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Course</th>
                <th>Question</th>
                <th>Options</th>
                <th>Correct Option</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $course_id = $row['course_id'];
                    $course_name = "";
                    $course_result = $conn->query("SELECT name FROM courses WHERE id='$course_id'");
                    if ($course_result->num_rows > 0) {
                        $course_name = $course_result->fetch_assoc()['name'];
                    }

                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$course_name}</td>
                            <td>{$row['question']}</td>
                            <td>{$row['option_a']} | {$row['option_b']} | {$row['option_c']} | {$row['option_d']}</td>
                            <td>{$row['correct_option']}</td>
                            <td>
                                <a href='?edit={$row['id']}' class='btn btn-warning'>Edit</a>
                                <form method='POST' action='' class='d-inline'>
                                    <button type='submit' name='delete_quiz' value='{$row['id']}' class='btn btn-danger'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>

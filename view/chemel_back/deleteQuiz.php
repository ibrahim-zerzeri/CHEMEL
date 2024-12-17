<?php
include_once '../../config.php';

if (isset($_POST['id'])) {
    $quiz_id = $_POST['id'];

    $conn = config::getConnexion();

    $sql = "DELETE FROM quizzes WHERE ID = :id";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':id', $quiz_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: ManageQuiz.php");
        exit();
    } else {
        echo "Error: Could not delete qiuz.";
    }
} else {
    echo "Error: No quiz ID provided.";
}
?>

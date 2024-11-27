<?php
include(__DIR__ . '/../config.php'); // Include the database configuration
include(__DIR__ . '/../Model/Quiz.php'); // Include the Quiz model

class QuizController
{
    // Add a new quiz
    public function addQuiz($quiz)
    {
        $sql = "INSERT INTO quizzes (COURSE_ID, SUBJECT_ID, QUESTION, OPTION_A, OPTION_B, OPTION_C, OPTION_D, CORRECT_OPTION) 
                VALUES (:course_id, :subject_id, :question, :option_a, :option_b, :option_c, :option_d, :correct_option)";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'course_id' => $quiz->getCourseId(),
                'subject_id' => $quiz->getSubjectId(),
                'question' => $quiz->getQuestion(),
                'option_a' => $quiz->getOptionA(),
                'option_b' => $quiz->getOptionB(),
                'option_c' => $quiz->getOptionC(),
                'option_d' => $quiz->getOptionD(),
                'correct_option' => $quiz->getCorrectOption()
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    // Update an existing quiz
    public function updateQuiz($quiz, $id)
    {
        $sql = "UPDATE quizzes SET 
                    COURSE_ID = :course_id,
                    SUBJECT_ID = :subject_id,
                    QUESTION = :question,
                    OPTION_A = :option_a,
                    OPTION_B = :option_b,
                    OPTION_C = :option_c,
                    OPTION_D = :option_d,
                    CORRECT_OPTION = :correct_option
                WHERE ID = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id' => $id,
                'course_id' => $quiz->getCourseId(),
                'subject_id' => $quiz->getSubjectId(),
                'question' => $quiz->getQuestion(),
                'option_a' => $quiz->getOptionA(),
                'option_b' => $quiz->getOptionB(),
                'option_c' => $quiz->getOptionC(),
                'option_d' => $quiz->getOptionD(),
                'correct_option' => $quiz->getCorrectOption()
            ]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    // Get all quizzes
    public function getAll()
    {
        $sql = "SELECT * FROM quizzes";
        $db = config::getConnexion();
        try {
            $query = $db->query($sql);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }

    // Get a single quiz by ID
    public function get($id)
    {
        $sql = "SELECT * FROM quizzes WHERE ID = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return new Quiz(
                    $result['ID'],
                    $result['COURSE_ID'],
                    $result['SUBJECT_ID'],
                    $result['QUESTION'],
                    $result['OPTION_A'],
                    $result['OPTION_B'],
                    $result['OPTION_C'],
                    $result['OPTION_D'],
                    $result['CORRECT_OPTION']
                );
            }
            return null; // No quiz found
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return null;
        }
    }

    // Delete a quiz by ID
    public function deleteQuiz($id)
    {
        $sql = "DELETE FROM quizzes WHERE ID = :id";
        $db = config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute(['id' => $id]);
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
    function fetchCourseById($course_id) {
        $conn = Config::getConnexion();
        $stmt = $conn->prepare("SELECT name FROM courses WHERE id = :course_id");
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    function fetchQuizzesByCourseId($course_id) {
        $conn = Config::getConnexion();
        $stmt = $conn->prepare("SELECT * FROM quizzes WHERE course_id = :course_id");
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    


}
?>

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
    
    //users results
    public function results()
    {
        $sql = "SELECT * FROM results";
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

    // Fetch course details by course_id
    public function fetchCourseById($course_id)
    {
        $conn = Config::getConnexion();
        $stmt = $conn->prepare("SELECT name FROM courses WHERE id = :course_id");
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Fetch quizzes based on course_id and level
    public function fetchQuizzesByCourseIdAndLevel($course_id, $level)
    {
        $conn = Config::getConnexion();
        
        // Prepare SQL query to fetch quizzes by course ID and level
        $stmt = $conn->prepare("
            SELECT * 
            FROM quizzes 
            WHERE course_id = :course_id 
            AND level = :level 
            ORDER BY RAND() 
            LIMIT 5
        ");
        
        // Bind parameters
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
        $stmt->bindParam(':level', $level, PDO::PARAM_INT);
    
        // Execute and fetch quizzes
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Save the score of the user
    // Save the score of the user
// Save the score of the user
public function saveScore($user, $score) {
    // Assuming $user is an object and user_id is a property of that object
    $user_id = $user->id;  // Access the 'id' property of the user object

    // Assuming you have a Database class with a method to get a connection
    $db = config::getConnexion();

    // First, fetch the existing score for the user from the 'results' table
    $query = "SELECT score FROM results WHERE user_id = :user_id LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    
    // Execute the query
    $stmt->execute();
    $existingScore = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existingScore) {
        // If there's already a score, calculate the average
        $oldScore = $existingScore['score'];
        $newScore = ($oldScore + $score) / 2; // Average of the old and new scores
        
        // Now, update the score with the new calculated score
        $updateQuery = "UPDATE results SET score = :score WHERE user_id = :user_id";
        $updateStmt = $db->prepare($updateQuery);
        $updateStmt->bindParam(':score', $newScore, PDO::PARAM_STR);  // Ensure the score is correctly bound (float as string)
        $updateStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        
        // Execute the update query
        try {
            $updateStmt->execute();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    } else {
        // If there's no existing score, insert a new record with the score
        $insertQuery = "INSERT INTO results (user_id, score) VALUES (:user_id, :score)";
        $insertStmt = $db->prepare($insertQuery);
        $insertStmt->bindParam(':score', $score, PDO::PARAM_STR);  // Ensure score is bound correctly
        $insertStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        
        // Execute the insert query
        try {
            $insertStmt->execute();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    // Return the new score or any result you wish
    return isset($newScore) ? $newScore : $score;
}
public function getUserScore($user)
{
    // Forcer le type en entier pour éviter les problèmes
    $user_id = $user->id;

    $sql = "SELECT score FROM results WHERE user_id = :user_id LIMIT 1";
    $db = config::getConnexion();
    try {
        $query = $db->prepare($sql);
        $query->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $query->execute();

        // Utiliser fetchColumn pour récupérer directement le score
        $score = $query->fetchColumn();

        return $score !== false ? (int) $score : null; // Forcer également le score en entier
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        return null;
    }
}





}
?>

<?php

include_once(__DIR__ . '/../../Controller/QuizController.php');
include_once(__DIR__ . '/../../Model/Quiz.php');

$quizController = new QuizController();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {  
    $course_id = intval($_GET['id']); 
    $course = $quizController->fetchCourseById($course_id); 
    $quizzes = $quizController->fetchQuizzesByCourseId($course_id);
} else {
    echo "Invalid or missing course ID.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $results = [];
    foreach ($quizzes as $quiz) {
        $user_answer = $_POST['quiz_' . $quiz['id']] ?? null; 

        $correct_answer = $quiz['correct_option'];
        $is_correct = ($user_answer === $correct_answer);
        $results[] = [
            'quiz_id' => $quiz['id'],
            'is_correct' => $is_correct,
            'user_answer' => $user_answer,
            'correct_answer' => $correct_answer
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizzes for <?php echo htmlspecialchars($course['name'] ?? 'Course'); ?></title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #ffffff;
            color: #333;
            padding: 20px;
            margin: 0;
        }
        h1 {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 700;
            color: #d4af37; /* Gold */
            margin-bottom: 20px;
        }
        .quiz-item {
            background-color: #fff;
            border: 1px solid #333; /* Black */
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }
        .quiz-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }
        label {
            display: block;
            padding: 12px;
            border: 1px solid #333; /* Black */
            border-radius: 8px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
            transition: all 0.3s ease;
        }
        label:hover, input[type="radio"]:checked + label {
            background: #d4af37; /* Gold */
            color: #fff;
            border-color: #d4af37;
        }
        input[type="radio"] {
            display: none;
        }
        .btn-submit {
            display: block;
            width: 100%;
            background-color: #d4af37; /* Gold */
            color: #fff;
            padding: 15px;
            border: none;
            border-radius: 8px;
            font-size: 1.2rem;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }
        .btn-submit:hover {
            background-color: #b2892d; /* Darker Gold */
        }
        .progress-container {
            position: sticky;
            top: 10px;
            margin-bottom: 20px;
        }
        .progress-bar {
            background: linear-gradient(90deg, #d4af37, #b2892d); /* Gold Gradient */
        }
        .results-container {
            margin-top: 30px;
            background: #fff;
            border: 1px solid #333; /* Black */
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .results-header {
            text-align: center;
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: #28a745; /* Green for success */
        }
        .score {
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: #333; /* Black */
        }
        .btn-return {
            display: block;
            text-align: center;
            margin: 30px auto 0;
            padding: 10px 20px;
            background-color: #d4af37; /* Gold */
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 1.1rem;
            width: fit-content;
            transition: background-color 0.3s ease;
        }
        .btn-return:hover {
            background-color: #b2892d; /* Darker Gold */
        }
        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }
            .btn-submit {
                font-size: 1rem;
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <h1>Quizzes for: <?php echo htmlspecialchars($course['name'] ?? 'Unknown'); ?></h1>

    <form method="POST">
        <?php if (!empty($quizzes)): ?>
            <div class="progress-container">
                <div class="progress">
                    <div class="progress-bar" id="progressBar" role="progressbar" style="width: 0%;">0%</div>
                </div>
            </div>
            <div id="quiz-container">
                <?php foreach ($quizzes as $index => $quiz): ?>
                    <div class="quiz-item">
                        <span class="badge bg-dark text-white mb-2">Question <?php echo $index + 1; ?> of <?php echo count($quizzes); ?></span>
                        <h3><?php echo htmlspecialchars($quiz['question']); ?></h3>
                        <?php foreach (['A', 'B', 'C', 'D'] as $option): ?>
                            <input type="radio" id="quiz_<?php echo $quiz['id'] . '_' . $option; ?>" name="quiz_<?php echo $quiz['id']; ?>" value="<?php echo $option; ?>">
                            <label for="quiz_<?php echo $quiz['id'] . '_' . $option; ?>">
                                <?php echo htmlspecialchars($quiz['option_' . strtolower($option)]); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="submit" class="btn-submit">Submit Answers</button>
        <?php else: ?>
            <p class="text-center text-danger">No quizzes found for this course.</p>
        <?php endif; ?>
    </form>

    <?php if (isset($results)): ?>
        <div class="results-container">
            <h2 class="results-header">Your Results</h2>
            <p class="score">Score: <?php echo round((array_sum(array_column($results, 'is_correct')) / count($results)) * 100); ?>%</p>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Your Answer</th>
                        <th>Correct Answer</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $result): ?>
                        <tr class="<?php echo $result['is_correct'] ? 'table-success' : 'table-danger'; ?>">
                            <td>Question <?php echo $result['quiz_id']; ?></td>
                            <td><?php echo htmlspecialchars($result['user_answer']); ?></td>
                            <td><?php echo htmlspecialchars($result['correct_answer']); ?></td>
                            <td>
                                <i class="fas <?php echo $result['is_correct'] ? 'fa-check-circle' : 'fa-times-circle'; ?>"></i>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <a href="coursedet.php?id=<?php echo $course_id; ?>" class="btn-return">Return to Course</a>

    <script>
        const progressBar = document.getElementById('progressBar');
        const totalQuizzes = <?php echo count($quizzes); ?>;
        const updateProgress = () => {
            const answered = document.querySelectorAll('input[type="radio"]:checked').length;
            const percentage = Math.round((answered / totalQuizzes) * 100);
            progressBar.style.width = `${percentage}%`;
            progressBar.textContent = `${percentage}%`;
        };
        document.querySelectorAll('input[type="radio"]').forEach(input => input.addEventListener('change', updateProgress));
    </script>
</body>
</html>

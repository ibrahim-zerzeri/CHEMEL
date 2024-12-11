<?php
// Database connection parameters
$dsn = "mysql:host=localhost;dbname=chemel;charset=utf8mb4";
$username = "root";
$password = "";

try {
    // Establish a PDO connection to the database
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Get the course ID from the URL (if it's set)
if (isset($_GET['id'])) {
    $coursedet_id = $_GET['id'];
} else {
    echo "Error: Course ID is missing.";
    exit;
}

// Query to fetch course details (course name and PDF file)
$query = "SELECT name AS course_name, pdf_file FROM courses WHERE id = :coursedet_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':coursedet_id', $coursedet_id, PDO::PARAM_INT);
$stmt->execute();

// Fetch the result as an associative array
$courseDetails = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Course Details</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
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
    <style>
        /* Chatbot container and styling */
        .chatbot-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 350px;
            background: linear-gradient(135deg, #333333, #1a1a1a);
            border: 2px solid #5b9df9;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            display: none; /* Initially hidden */
        }

        .chatbot-header {
            background: linear-gradient(135deg, #5b9df9, #6c63ff);
            color: #fff;
            text-align: center;
            padding: 10px;
            font-size: 18px;
            font-weight: bold;
        }

        .chatbot-body {
            height: 400px;
            overflow-y: auto;
            padding: 10px;
            color: #ddd;
            font-family: 'Open Sans', sans-serif;
        }

        .chatbot-input {
            display: flex;
            padding: 10px;
            background: #222;
        }

        .chatbot-input input {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 5px;
            margin-right: 10px;
            background: #333;
            color: #fff;
        }

        .chatbot-input button {
            background: linear-gradient(135deg, #6c63ff, #5b9df9);
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        /* Time tracker and color update */
        .time-spent {
            margin-top: 20px;
            font-size: 18px;
            color: #5b9df9;
        }

        .goal-progress {
            width: 100%;
            height: 10px;
            background: #ddd;
            margin-top: 10px;
            border-radius: 5px;
            overflow: hidden;
        }

        .goal-progress-bar {
            height: 100%;
            width: 0;
            background: red;
            transition: width 0.5s, background 0.5s;
        }

        .open-chatbot-btn {
            position: fixed;
            bottom: 80px;
            right: 20px;
            background: linear-gradient(135deg, #6c63ff, #5b9df9);
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .open-chatbot-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>

<!-- Course Details -->
<section class="ftco-section bg-light">
    <div class="container">
        <div class="row">
            <?php if ($courseDetails): ?>
                <div class="col-md-12">
                    <h2><?php echo htmlspecialchars($courseDetails['course_name']); ?></h2>

                    <?php if ($courseDetails['pdf_file']): ?>
                        <p>
                            <a href="/chemel/view/chemel_back/<?php echo htmlspecialchars($courseDetails['pdf_file']); ?>" target="_blank">
                                <button class="futuristic-button">View PDF</button>
                            </a>
                            <a href="/chemel/view/chemel_back/<?php echo htmlspecialchars($courseDetails['pdf_file']); ?>" download>
                                <button class="futuristic-button">Download PDF</button>
                            </a>
                        </p>
                    <?php else: ?>
                        <p>PDF not available for this course.</p>
                    <?php endif; ?>

                    <p class="time-spent" id="timeSpentDisplay">Time spent on this course: 0h 0m 0s</p>
                    <div class="goal-progress">
                        <div class="goal-progress-bar" id="progressBar"></div>
                    </div>
                </div>
            <?php else: ?>
                <div class="col-md-12 text-center">
                    <p>No course details available.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="ftco-footer ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <p>© 2024 Chemel</p>
            </div>
        </div>
    </div>
</footer>

<!-- Open Chatbot Button -->
<button class="open-chatbot-btn" id="openChatbotBtn">Chat with us!</button>

<!-- Chatbot Container -->
<div class="chatbot-container" id="chatbotContainer">
    <div class="chatbot-header">Chatbot</div>
    <div class="chatbot-body">
        <!-- Chatbot content goes here -->
        <p>How can I help you today?</p>
    </div>
    <div class="chatbot-input">
        <input type="text" placeholder="Type a message..." />
        <button>Send</button>
    </div>
</div>

<!-- JavaScript files -->
<script src="js/jquery.min.js"></script>
<script src="js/jquery-migrate-3.0.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<script>
// Track the time spent on the course
let startTime = Date.now();
let timeSpent = 0; // Time spent in milliseconds
let goalTime = 40 * 60 * 1000; // Goal: 40 minutes in milliseconds

// Function to format the time into hours, minutes, and seconds
function formatTime(ms) {
    const totalSeconds = Math.floor(ms / 1000);
    const hours = Math.floor(totalSeconds / 3600);
    const minutes = Math.floor((totalSeconds % 3600) / 60);
    const seconds = totalSeconds % 60;
    return `${hours}h ${minutes}m ${seconds}s`;
}

// Update the time spent every second
setInterval(function() {
    timeSpent = Date.now() - startTime; // Calculate elapsed time
    document.getElementById('timeSpentDisplay').innerText = "Time spent on this course: " + formatTime(timeSpent);

    // Update progress bar and color based on time spent
    let progress = (timeSpent / goalTime) * 100;
    let progressBar = document.getElementById('progressBar');
    progressBar.style.width = progress + '%';

    // Color change based on progress
    if (timeSpent < 10 * 60 * 1000) {
        progressBar.style.backgroundColor = 'red';
    } else if (timeSpent >= goalTime) {
        progressBar.style.backgroundColor = 'green';
    } else {
        progressBar.style.backgroundColor = 'yellow';
    }
}, 1000); // Update every second

// Toggle chatbot visibility
document.getElementById('openChatbotBtn').addEventListener('click', function() {
    let chatbot = document.getElementById('chatbotContainer');
    chatbot.style.display = chatbot.style.display === 'none' ? 'block' : 'none';
});
</script>

</body>
</html>

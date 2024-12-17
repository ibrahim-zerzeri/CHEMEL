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

// Check if course details are found
if (!$courseDetails) {
    echo "No course details available.";
    exit; // Exit if no course details are found
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Course Details</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto|Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        /* Global Styles */
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        h2, h3 {
            font-weight: 600;
            color: #333;
        }

        /* Course Container */
        .course-container {
            position: relative;
            display: flex;
            justify-content: center;
            margin: 50px 0;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            min-height: 500px;
        }

        /* Right Column (PDF and Feedback Section) */
        .course-content {
            flex: 1;
            padding-right: 200px; /* Make room for the clock */
        }

        .course-content iframe {
            width: 100%;
            height: 80vh;
            border: none;
            display: none; /* Hide the PDF initially */
        }

        /* Modern Button Style */
        .futuristic-button {
            background: linear-gradient(45deg, #6c63ff, #6a5acd);
            color: #fff;
            border: none;
            padding: 10px 25px;
            font-size: 16px;
            border-radius: 50px;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .futuristic-button:hover {
            background: linear-gradient(45deg, #6a5acd, #6c63ff);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            transform: scale(1.05);
        }

        .futuristic-button a {
            text-decoration: none;
            color: white;
        }

        /* Clock - Positioned at Top Right */
        .clock-container {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 150px;
            height: 150px;
            border: 10px solid #ddd;
            border-radius: 50%;
            background: conic-gradient(
                green 0deg 0deg, /* time spent in green */
                red 0deg 180deg, /* time left in red */
                #ddd 0deg 360deg /* background */
            );
            margin: 0;
            padding: 20px;
        }

        .time-display {
            font-size: 24px;
            font-weight: bold;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #333;
        }

        /* Feedback Section - Positioned at Bottom Right */
        .feedback-section {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .feedback-section h3 {
            font-size: 1.75rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .feedback-section textarea {
            width: 100%;
            height: 150px;
            padding: 15px;
            font-size: 1rem;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-bottom: 15px;
            transition: border 0.3s ease;
        }

        .feedback-section textarea:focus {
            border: 1px solid #6c63ff;
            outline: none;
        }

        .feedback-section button {
            background-color: #6c63ff;
            border: none;
            color: white;
            padding: 10px 25px;
            font-size: 16px;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .feedback-section button:hover {
            background-color: #5a52e1;
        }

        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #333;
            color: white;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            font-weight: 300;
        }

        footer a {
            color: white;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        .encouragement-message {
            margin-top: 15px;
            font-weight: bold;
            color: green;
        }
    </style>
</head>
<body>

<!-- Course Details Section -->
<section class="course-container">
    <div class="container">
        <div class="course-content">
            <h2><?php echo htmlspecialchars($courseDetails['course_name']); ?></h2>

            <?php if ($courseDetails['pdf_file']): ?>
                <button class="futuristic-button" id="viewPdfBtn">View PDF</button>
                <button class="futuristic-button" id="downloadPdfBtn">
                    <a href="/chemel/view/chemel_back/<?php echo htmlspecialchars($courseDetails['pdf_file']); ?>" download>
                        Download PDF
                    </a>
                </button>
      <!-- Form to select quiz level and pass course ID -->
      <form method="GET" action="quiz.php">
                <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id']); ?>">
                <label for="level">Select Quiz Level</label>
                <select name="level" id="level" required>
                    <option value="" selected disabled>Choose a quiz level</option>
                    <option value="1">Easy</option>
                    <option value="2">Medium</option>
                    <option value="3">Hard</option>
                </select>
                <button class="btn btn-primary mt-2" type="submit">Go to Quiz</button>
            </form>

                <!-- PDF Container (Hidden by default) -->
                <iframe id="pdfIframe" src="/chemel/view/chemel_back/<?php echo htmlspecialchars($courseDetails['pdf_file']); ?>"></iframe>
            <?php else: ?>
                <p>PDF not available for this course.</p>
            <?php endif; ?>
        </div>
    </div>
</section>


<!-- Clock -->
<div class="clock-container">
    <div class="time-display" id="timeDisplay">00:00</div>
</div>

<!-- Feedback Section -->
<div class="feedback-section">
    <h3>Leave Your Feedback</h3>
    <textarea id="feedbackText" placeholder="Share your thoughts..." required></textarea><br>
    <button type="button" class="futuristic-button" id="submitFeedbackBtn">Submit Feedback</button>

    <!-- Display Feedback -->
    <div class="feedback-list" id="feedbackList"></div>

    <!-- Encouragement Message -->
    <div id="encouragementMessage" class="encouragement-message"></div>
</div>

<!-- Footer -->
<footer>
    <p>© 2024 Chemel. All rights reserved. <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
</footer>

<!-- JavaScript -->
<script src="js/jquery.min.js"></script>
<script src="js/jquery-migrate-3.0.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<script>
// Toggle PDF visibility on button click
document.getElementById('viewPdfBtn').addEventListener('click', function() {
    const pdfIframe = document.getElementById('pdfIframe');
    pdfIframe.style.display = pdfIframe.style.display === 'none' || pdfIframe.style.display === '' ? 'block' : 'none';
});

// Time spent tracking
let startTime = Date.now();
let timeSpent = 0; // Time spent in milliseconds
let goalTime = 40 * 60 * 1000; // Goal time in milliseconds (40 minutes)

function updateClock() {
    const elapsed = Date.now() - startTime;
    timeSpent = Math.min(elapsed, goalTime);
    const minutes = Math.floor(timeSpent / 60000);
    const seconds = Math.floor((timeSpent % 60000) / 1000);
    const timeDisplay = document.getElementById('timeDisplay');
    timeDisplay.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

    // Update clock background color based on progress
    const percentage = timeSpent / goalTime;
    const clock = document.querySelector('.clock-container');
    clock.style.background = `conic-gradient(
        green ${percentage * 360}deg,
        red ${(1 - percentage) * 360}deg,
        #ddd 0deg 360deg
    )`;

    // Change the clock color to green if the goal is reached
    if (timeSpent >= goalTime) {
        clock.style.backgroundColor = '#28a745';
    }
}

setInterval(updateClock, 1000);

// Submit Feedback
document.getElementById('submitFeedbackBtn').addEventListener('click', function() {
    const feedbackText = document.getElementById('feedbackText').value;
    if (feedbackText) {
        const feedbackList = document.getElementById('feedbackList');
        const feedbackMessage = document.createElement('p');
        feedbackMessage.textContent = feedbackText;
        feedbackList.appendChild(feedbackMessage);
        document.getElementById('feedbackText').value = '';

        document.getElementById('encouragementMessage').textContent = "Thank you for your feedback!";
    } else {
        alert("Please enter feedback.");
    }
});
</script>

</body>
</html>

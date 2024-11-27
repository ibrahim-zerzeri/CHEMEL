<?php
// Step 1: Connect to the Database using PDO
$dsn = "mysql:host=localhost;dbname=chemel;charset=utf8mb4";
$username = "root";
$password = "";

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Step 2: Query to Fetch Subjects
try {
    $stmt = $conn->query("SELECT * FROM subjects"); // Adjust query to match your table and column names
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

// Step 3: HTML Structure Begins
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Subjects</title>
</head>
<body>
<!-- Hero Section -->
<div class="hero-wrap hero-bread" style="background-image: url('images/bg_6.jpg');">
    <div class="container">
        <div class="row no-gutters slider-text align-items-center justify-content-center">
            <div class="col-md-9 ftco-animate text-center">
                <h1 class="mb-0 bread">Subjects</h1>
            </div>
        </div>
    </div>
</div>

<!-- Subject Cards -->
<div class="container py-5">
    <div class="row">
        <?php
        // Step 4: Display Subjects Dynamically
        if (!empty($subjects)) {
            foreach ($subjects as $row) {
                $subject_id = htmlspecialchars($row["id"]);       // Subject ID for linking
                $subject_name = htmlspecialchars($row["name"]);   // Subject Name
                $subject_image = !empty($row["image"]) 
                                ? htmlspecialchars($row["image"]) 
                                : 'images/placeholder.jpg';       // Default placeholder image

                // Subject Card
                echo '
                <div class="col-md-4 d-flex mb-4">
                    <div class="card">
                        <img class="card-img-top img-fluid" src="' . $subject_image . '" alt="' . $subject_name . '">
                        <div class="card-body text-center">
                            <h5 class="card-title">' . $subject_name . '</h5>
                            <a href="courses.php?subject_id=' . $subject_id . '" class="btn btn-primary">Go to Courses</a>
                        </div>
                    </div>
                </div>';
            }
        } else {
            // No Subjects Found
            echo '<p class="text-center w-100">No subjects found.</p>';
        }
        ?>
    </div>
</div>

<!-- Footer -->
<footer class="text-center py-4">
    <p>&copy; 2024 Chemel</p>
</footer>

<!-- JS Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

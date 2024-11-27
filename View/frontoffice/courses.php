<!DOCTYPE html>
<html lang="en">
<head>
    <title>Courses</title>
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
</head>
<body>
    <!-- Header -->
    <div class="hero-wrap hero-bread" style="background-image: url('images/bg_6.jpg');">
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <h1 class="mb-0 bread">Courses</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row">
                <?php
                // Database connection setup
                $dsn = "mysql:host=localhost;dbname=chemel;charset=utf8mb4";
                $db_user = "root";
                $db_pass = "";

                try {
                    // Establishing the PDO connection
                    $pdo = new PDO($dsn, $db_user, $db_pass);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Check if `subject_id` is provided and valid
                    $subject_id = isset($_GET['subject_id']) ? intval($_GET['subject_id']) : 0;

                    if ($subject_id > 0) {
                        // Query to fetch courses for the provided subject
                        $stmt = $pdo->prepare("SELECT * FROM courses WHERE subject_id = :subject_id");
                        $stmt->execute(['subject_id' => $subject_id]);

                        if ($stmt->rowCount() > 0) {
                            // Display each course as a card
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<div class="col-md-4 col-lg-3 ftco-animate">';
                                echo '  <div class="product">';
                                echo '    <a href="#" class="img-prod"><img class="img-fluid" src="images/default_course.jpg" alt="Course Image">';
                                echo '      <div class="overlay"></div>';
                                echo '    </a>';
                                echo '    <div class="text py-3 pb-4 px-3">';
                                echo '      <h3><a href="coursedet.php?id=' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['name']) . '</a></h3>';
                                echo '      <p class="bottom-area d-flex px-3">';
                                echo '        <a href="coursedet.php?id=' . htmlspecialchars($row['id']) . '" class="add-to-cart text-center py-2 mr-1"><span>View Details</span></a>';
                                echo '      </p>';
                                echo '    </div>';
                                echo '  </div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<div class="col-md-12 text-center">';
                            echo '  <p>No courses found for this subject.</p>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="col-md-12 text-center">';
                        echo '  <p>Invalid subject selected. Please select a valid subject.</p>';
                        echo '</div>';
                    }
                } catch (PDOException $e) {
                    echo '<div class="col-md-12 text-center">';
                    echo '  <p>Database Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="ftco-footer ftco-section">
        <div class="container">
            <!-- Footer content omitted for brevity -->
        </div>
    </footer>

    <!-- JavaScript files -->
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/jquery.waypoints.min.js"></script>
    <script src="js/jquery.stellar.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/aos.js"></script>
    <script src="js/jquery.animateNumber.min.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/scrollax.min.js"></script>
    <script src="js/google-map.js"></script>
    <script src="js/main.js"></script>
</body>
</html>

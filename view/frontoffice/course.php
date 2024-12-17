<!DOCTYPE html>
<html lang="en">
<head>
    <title>Chapters</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Header -->
    <div class="hero-wrap hero-bread" style="background-image: url('images/bg_6.jpg');">
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-9 ftco-animate text-center">
                    <h1 class="mb-0 bread">Chapters</h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Form -->
    <div class="container my-4">
        <form method="GET" action="" class="form-inline justify-content-center">
            <input type="hidden" name="course_id" value="<?= isset($_GET['course_id']) ? intval($_GET['course_id']) : '' ?>">
            <input type="text" name="search" class="form-control mr-2" placeholder="Search chapters..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>

    <!-- Main Content -->
    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row">
                <?php
                // Database connection setup with PDO
                $dsn = "mysql:host=localhost;dbname=chemel;charset=utf8mb4";
                $db_user = "root";
                $db_pass = "";

                try {
                    $pdo = new PDO($dsn, $db_user, $db_pass);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Get course_id and search term from the URL
                    $course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;
                    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

                    if ($course_id > 0) {
                        // Query to fetch chapters based on course_id and optional search term
                        if (!empty($searchTerm)) {
                            $stmt = $pdo->prepare(
                                "SELECT * FROM chapters WHERE course_id = :course_id AND name LIKE :search"
                            );
                            $stmt->execute([
                                'course_id' => $course_id,
                                'search' => '%' . $searchTerm . '%'
                            ]);
                        } else {
                            $stmt = $pdo->prepare(
                                "SELECT * FROM chapters WHERE course_id = :course_id"
                            );
                            $stmt->execute(['course_id' => $course_id]);
                        }

                        if ($stmt->rowCount() > 0) {
                            // Loop through and display each chapter as a card
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<div class="col-md-4 col-lg-3 ftco-animate">';
                                echo '  <div class="product">';
                                echo '    <a href="#" class="img-prod"><img class="img-fluid" src="images/default_subject.jpg" alt="Chapter Image">';
                                echo '      <div class="overlay"></div>';
                                echo '    </a>';
                                echo '    <div class="text py-3 pb-4 px-3">';
                                echo '      <h3><a href="chapter_details.php?chapter_id=' . htmlspecialchars($row['id']) . '">' . htmlspecialchars($row['name']) . '</a></h3>';
                                echo '      <p class="bottom-area d-flex px-3">';
                                echo '        <a href="chapter_details.php?chapter_id=' . htmlspecialchars($row['id']) . '" class="add-to-cart text-center py-2 mr-1"><span>View Details</span></a>';
                                echo '      </p>';
                                echo '    </div>';
                                echo '  </div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<div class="col-md-12 text-center">';
                            echo '  <p>No chapters found for this course.</p>';
                            echo '</div>';
                        }
                    } else {
                        echo '<div class="col-md-12 text-center">';
                        echo '  <p>Invalid course ID.</p>';
                        echo '</div>';
                    }
                } catch (PDOException $e) {
                    echo '<div class="col-md-12 text-center"><p>Error: ' . $e->getMessage() . '</p></div>';
                }
                ?>
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

    <!-- JavaScript files -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>

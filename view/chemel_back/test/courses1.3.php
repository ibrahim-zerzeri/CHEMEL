<?php
class Config
{
    private static $pdo = null;

    public static function getConnexion()
    {
        if (!isset(self::$pdo)) {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "chemel";

            try {
                self::$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                die('Erreur: ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}

$conn = Config::getConnexion();

// Helper function to fetch subjects
function getSubjects($conn)
{
    $stmt = $conn->query("SELECT * FROM subjects");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Handle form submission for adding or editing a course
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    $course_name = $_POST['course_name'] ?? '';
    $subject_id = $_POST['subject_id'] ?? '';
    $pdf_file_path = $_POST['existing_pdf'] ?? '';

    // Handle file upload if provided
    if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === 0) {
        $pdf_file = $_FILES['pdf_file'];
        $pdf_file_name = $pdf_file['name'];
        $pdf_file_tmp = $pdf_file['tmp_name'];
        $pdf_file_size = $pdf_file['size'];
        $allowed_exts = ['pdf'];
        $file_ext = pathinfo($pdf_file_name, PATHINFO_EXTENSION);

        // Validate file type and size (10MB max)
        if (in_array($file_ext, $allowed_exts) && $pdf_file_size <= 10485760) {
            $course_name_clean = preg_replace('/[^a-zA-Z0-9-_]/', '_', $course_name);
            $new_pdf_file_name = $course_name_clean . '.' . $file_ext;
            $pdf_file_path = 'uploads/' . $new_pdf_file_name;
            move_uploaded_file($pdf_file_tmp, $pdf_file_path);
        } else {
            echo "Invalid file type or size exceeds 10MB.";
            exit;
        }
    }

    if ($action == 'add') {
        // Validate that subject_id exists in the database
        $stmt = $conn->prepare("SELECT COUNT(*) FROM subjects WHERE id = :subject_id");
        $stmt->execute([':subject_id' => $subject_id]);
        if ($stmt->fetchColumn() == 0) {
            echo "Invalid subject selected.";
            exit;
        }

        // Insert the course into the database
        $stmt = $conn->prepare("INSERT INTO courses (name, pdf_file, subject_id) VALUES (:name, :pdf_file, :subject_id)");
        $stmt->execute([
            ':name' => $course_name,
            ':pdf_file' => $pdf_file_path,
            ':subject_id' => $subject_id
        ]);
        echo "Course added successfully.";
    } elseif ($action == 'edit') {
        $course_id = $_POST['course_id'] ?? '';

        // Update the course in the database
        $stmt = $conn->prepare("UPDATE courses SET name = :name, pdf_file = :pdf_file, subject_id = :subject_id WHERE id = :id");
        $stmt->execute([
            ':name' => $course_name,
            ':pdf_file' => $pdf_file_path,
            ':subject_id' => $subject_id,
            ':id' => $course_id
        ]);
        echo "Course updated successfully.";
    }
}

// Handle delete request
if (isset($_GET['delete'])) {
    $course_id = $_GET['delete'];

    // Fetch course details to delete the file
    $stmt = $conn->prepare("SELECT pdf_file FROM courses WHERE id = :id");
    $stmt->execute([':id' => $course_id]);
    $course = $stmt->fetch();

    if ($course && file_exists($course['pdf_file'])) {
        unlink($course['pdf_file']); // Delete the file
    }

    // Delete the course from the database
    $stmt = $conn->prepare("DELETE FROM courses WHERE id = :id");
    $stmt->execute([':id' => $course_id]);

    echo "Course deleted successfully.";
}

// Fetch subjects and courses
$subjects = getSubjects($conn);
$courses_result = $conn->query("SELECT * FROM courses")->fetchAll(PDO::FETCH_ASSOC);

// Prefill the edit form if ?edit=<course_id> is set
$course_to_edit = null;
if (isset($_GET['edit'])) {
    $course_id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM courses WHERE id = :id");
    $stmt->execute([':id' => $course_id]);
    $course_to_edit = $stmt->fetch();
}
?>

<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Courses</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="./assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="./assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/libs/css/style.css">
    <link rel="stylesheet" href="./assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" type="text/css" href="./assets/vendor/datatables/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="./assets/vendor/datatables/css/buttons.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="./assets/vendor/datatables/css/select.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="./assets/vendor/datatables/css/fixedHeader.bootstrap4.css">
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
         <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
         <div class="dashboard-header">
            <nav class="navbar navbar-expand-lg bg-white fixed-top">
                <a class="navbar-brand" href="../index.html">Concept</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse " id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto navbar-right-top">
                        <li class="nav-item">
                            <div id="custom-search" class="top-search-bar">
                                <input class="form-control" type="text" placeholder="Search..">
                            </div>
                        </li>
                        <li class="nav-item dropdown notification">
                            <a class="nav-link nav-icons" href="#" id="navbarDropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-fw fa-bell"></i> <span class="indicator"></span></a>
                            <ul class="dropdown-menu dropdown-menu-right notification-dropdown">
                                <li>
                                    <div class="notification-title"> Notification</div>
                                    <div class="notification-list">
                                        <div class="list-group">
                                            <a href="#" class="list-group-item list-group-item-action active">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="../assets/images/avatar-2.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">Jeremy Rakestraw</span>accepted your invitation to join the team.
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="../assets/images/avatar-3.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">
John Abraham</span>is now following you
                                                        <div class="notification-date">2 days ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="../assets/images/avatar-4.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">Monaan Pechi</span> is watching your main repository
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="#" class="list-group-item list-group-item-action">
                                                <div class="notification-info">
                                                    <div class="notification-list-user-img"><img src="../assets/images/avatar-5.jpg" alt="" class="user-avatar-md rounded-circle"></div>
                                                    <div class="notification-list-user-block"><span class="notification-list-user-name">Jessica Caruso</span>accepted your invitation to join the team.
                                                        <div class="notification-date">2 min ago</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="list-footer"> <a href="#">View all notifications</a></div>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown connection">
                            <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fas fa-fw fa-th"></i> </a>
                            <ul class="dropdown-menu dropdown-menu-right connection-dropdown">
                                <li class="connection-list">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="../assets/images/github.png" alt="" > <span>Github</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="../assets/images/dribbble.png" alt="" > <span>Dribbble</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="../assets/images/dropbox.png" alt="" > <span>Dropbox</span></a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="../assets/images/bitbucket.png" alt=""> <span>Bitbucket</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="../assets/images/mail_chimp.png" alt="" ><span>Mail chimp</span></a>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12 ">
                                            <a href="#" class="connection-item"><img src="../assets/images/slack.png" alt="" > <span>Slack</span></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="conntection-footer"><a href="#">More</a></div>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown nav-user">
                            <a class="nav-link nav-user-img" href="#" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../assets/images/avatar-1.jpg" alt="" class="user-avatar-md rounded-circle"></a>
                            <div class="dropdown-menu dropdown-menu-right nav-user-dropdown" aria-labelledby="navbarDropdownMenuLink2">
                                <div class="nav-user-info">
                                    <h5 class="mb-0 text-white nav-user-name">
John Abraham</h5>
                                    <span class="status"></span><span class="ml-2">Available</span>
                                </div>
                                <a class="dropdown-item" href="#"><i class="fas fa-user mr-2"></i>Account</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-cog mr-2"></i>Setting</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-power-off mr-2"></i>Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
            
                            <!-- Marketplace Menu (Selected when Orders page is open) -->
                            <li class="nav-item">
                                <a class="nav-link active" href="#" data-toggle="collapse" aria-expanded="true" data-target="#submenu-marketplace" aria-controls="submenu-marketplace">
                                    <i class="fa fa-fw fa-rocket"></i>Marketplace
                                </a>
                                <div id="submenu-marketplace" class="collapse show submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="products.html">Products</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active" href="orders.html">Orders</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
            
                            <!-- User Management Menu -->
                            <li class="nav-item">
                                <a class="nav-link" href="user-management.html" data-toggle="collapse" aria-expanded="false" data-target="#submenu-user-management" aria-controls="submenu-user-management">
                                    <i class="fa fa-fw fa-users"></i>User Management
                                </a>
                                <div id="submenu-user-management" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="user-management.html">Manage Users</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
            
                            <!-- Learning Section -->
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-learning" aria-controls="submenu-learning">
                                    <i class="fa fa-fw fa-book"></i>Learning
                                </a>
                                <div id="submenu-learning" class="collapse submenu">
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="courses.php">Courses</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="subjects.php">Subjects</a>
                                        <li class="nav-item">
                                                <a class="nav-link" href="quiz.html">Quiz</a>
                                        </li>
                                        </li>
                                    </ul>
                                </div>
                            </li>
            
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        
        
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
        <h1 class="my-4">Manage Courses</h1>

<!-- Add/Edit Course Form -->
<form method="POST" enctype="multipart/form-data" class="mb-4">
    <input type="hidden" name="action" value="<?= $course_to_edit ? 'edit' : 'add'; ?>">
    <?php if ($course_to_edit): ?>
        <input type="hidden" name="course_id" value="<?= $course_to_edit['id']; ?>">
        <input type="hidden" name="existing_pdf" value="<?= $course_to_edit['pdf_file']; ?>">
    <?php endif; ?>

    <div class="form-group">
        <label for="course_name">Course Name</label>
        <input type="text" name="course_name" id="course_name" class="form-control" 
            value="<?= $course_to_edit['name'] ?? ''; ?>" required>
    </div>

    <div class="form-group">
        <label for="subject_name">Subject</label>
        <select name="subject_id" id="subject_name" class="form-control" required>
            <option value="">Select Subject</option>
            <?php foreach ($subjects as $subject): ?>
                <option value="<?= $subject['id']; ?>" 
                    <?= $course_to_edit && $subject['id'] == $course_to_edit['subject_id'] ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($subject['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="pdf_file">PDF File <?= $course_to_edit ? '(Optional)' : ''; ?></label>
        <input type="file" name="pdf_file" id="pdf_file" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">
        <?= $course_to_edit ? 'Update Course' : 'Add Course'; ?>
    </button>
</form>

<h2 class="my-4">Existing Courses</h2>
<table class="table">
    <thead>
        <tr>
            <th>Course Name</th>
            <th>Subject</th>
            <th>PDF File</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($courses_result as $course): ?>
            <tr>
                <td><?= htmlspecialchars($course['name']); ?></td>
                <td>
                    <?php
                    $stmt = $conn->prepare("SELECT name FROM subjects WHERE id = :id");
                    $stmt->execute([':id' => $course['subject_id']]);
                    $subject = $stmt->fetch();
                    echo htmlspecialchars($subject['name']);
                    ?>
                </td>
                <td>
                    <a href="?course_name=<?= urlencode($course['name']); ?>" target="_blank">Download</a>
                </td>
                <td>
                    <a href="?edit=<?= $course['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="?delete=<?= $course['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this course?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>   
                    <!-- ============================================================== -->
                    <!-- data table  -->
                    <!-- ============================================================== -->
                 
    <!-- ============================================================== -->
    <!-- end main wrapper -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <script src="../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <script src="../assets/vendor/multi-select/js/jquery.multi-select.js"></script>
    <script src="../assets/libs/js/main-js.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="../assets/vendor/datatables/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="../assets/vendor/datatables/js/buttons.bootstrap4.min.js"></script>
    <script src="../assets/vendor/datatables/js/data-table.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/rowgroup/1.0.4/js/dataTables.rowGroup.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.1.5/js/dataTables.fixedHeader.min.js"></script>
    
</body>
 
</html>
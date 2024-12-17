<?php
// Include configuration file
include 'config.php';

// Validate the 'page' parameter to prevent invalid inputs
$allowed_pages = ['courses', 'subjects', 'coursedet']; // Add 'coursedet' to the list of allowed pages
$page = isset($_GET['page']) && in_array($_GET['page'], $allowed_pages) ? $_GET['page'] : null;

// Load the appropriate page or display an error
if ($page) {
    include $page . '.php'; // Include courses.php, subjects.php, or coursedet.php dynamically
} else {
    echo '<div class="alert alert-warning text-center">Please select a valid page.</div>';
}
?>

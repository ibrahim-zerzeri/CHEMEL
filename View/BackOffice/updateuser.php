<?php
include '../../controller/UserController.php';

$error = "";
$userController = new UserController();

if (isset($_GET['id'])) {
    $user = $userController->getUserById($_GET['id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['username']) && isset($_POST['email']) && isset($_POST['role'])
        && !empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['role'])
    ) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        // Update user details in the database
        $userController->updateUser($user['id'], $username, $email, $role);

        header('Location: user-management.php');
        exit;
    } else {
        $error = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Edit User</h1>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required><br>

            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                <option value="user" <?php echo $user['role'] == 'user' ? 'selected' : ''; ?>>User</option>
            </select><br>

            <button type="submit">Update User</button>
        </form>
        <?php if ($error) echo "<p>$error</p>"; ?>
    </div>
</body>
</html>

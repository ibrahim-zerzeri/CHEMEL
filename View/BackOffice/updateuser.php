<?php
include '../../controller/UserController.php';

$offerController = new UserController();
$error = "";
$offer = null;

// Fetch the user details if the `id` is provided
if (isset($_GET['id'])) {
    $offer = $offerController->showUser($_GET['id']);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'],$_POST['email'], $_POST['username'], $_POST['password'], $_POST['birthday'], $_POST['establishment'])) {
    if (
        !empty($_POST['id']) &&
        !empty($_POST['email']) &&
        !empty($_POST['username']) &&
        !empty($_POST['password']) &&
        !empty($_POST['birthday']) &&
        !empty($_POST['establishment'])
    ) {
        // Create a new user object
        $offer = new User(
            null,
            $_POST['email'],
            $_POST['username'],
            $_POST['password'],
            $_POST['birthday'],
            $_POST['establishment']
        );

        // Update the user in the database
        $offerController->updateUser($offer, $_POST['id']);

        // Redirect to user list after update
        header('Location:User-management.php');
        exit;
    } else {
        $error = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Update User - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fc;
        }

        .card {
            max-width: 500px;
            width: 100%;
        }

        label {
            font-weight: bold;
        }

        .alert {
            text-align: center;
        }
    </style>

    <script>
        function validateForm() {
            let isValid = true;

            // Validate Username
            const username = document.getElementById('username').value.trim();
            const usernameError = document.getElementById('username_error');
            if (!/^[a-zA-Z]+$/.test(username)) {
                usernameError.textContent = 'Username must contain only letters with no spaces.';
                usernameError.style.color = 'red';
                isValid = false;
            } else {
                usernameError.textContent = '';
            }

            // Validate Password
            const password = document.getElementById('password').value;
            const passwordError = document.getElementById('password_error');
            if (!/(?=.*[a-zA-Z])(?=.*\d)/.test(password)) {
                passwordError.textContent = 'Password must contain both letters and numbers.';
                passwordError.style.color = 'red';
                isValid = false;
            } else {
                passwordError.textContent = '';
            }

            // Validate Birthday
            const birthday = document.getElementById('birthday').value;
            const birthdayError = document.getElementById('birthday_error');
            if (!/^\d{4}$/.test(birthday)) {
                birthdayError.textContent = 'Birthday must be exactly 4 digits.';
                birthdayError.style.color = 'red';
                isValid = false;
            } else {
                birthdayError.textContent = '';
            }

            // Validate Establishment
            const establishment = document.getElementById('establishment').value.trim();
            const establishmentError = document.getElementById('establishment_error');
            if (establishment === '') {
                establishmentError.textContent = 'Establishment is required.';
                establishmentError.style.color = 'red';
                isValid = false;
            } else {
                establishmentError.textContent = '';
            }

            return isValid;
        }
    </script>
</head>

<body>

    <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">

                <?php if (!empty($error)) : ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form action="" method="POST" onsubmit="return validateForm();">
                    <!-- Hidden ID field -->
                    <input type="hidden" name="id" value="<?= htmlspecialchars($_GET['id'] ?? $_POST['id'] ?? '') ?>">

                    <label for="email">Email:</label>
                    <input class="form-control form-control-user" type="text" id="email" name="email" value="<?= htmlspecialchars($offer['email'] ?? '') ?>" required>
                    <span id="email_error"></span>

                    <label for="username">Username:</label>
                    <input class="form-control form-control-user" type="text" id="username" name="username" value="<?= htmlspecialchars($offer['username'] ?? '') ?>" required>
                    <span id="username_error"></span>

                    <label for="password">Password:</label>
                    <input class="form-control form-control-user" type="password" id="password" name="password" value="<?= htmlspecialchars($offer['password'] ?? '') ?>" required>
                    <span id="password_error"></span>

                    <label for="birthday">Birthday:</label>
                    <input class="form-control form-control-user" type="number" id="birthday" name="birthday" value="<?= htmlspecialchars($offer['birthday'] ?? '') ?>" required>
                    <span id="birthday_error"></span>

                    <label for="establishment">Establishment:</label>
                    <input class="form-control form-control-user" type="text" id="establishment" name="establishment" value="<?= htmlspecialchars($offer['establishment'] ?? '') ?>" required>
                    <span id="establishment_error"></span>

                    <br>
                    <button type="submit" class="btn btn-primary btn-user btn-block">Update User</button>
                </form>

            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>


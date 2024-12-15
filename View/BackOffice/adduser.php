<?php
include '../../controller/BasketController.php';
include '../../controller/UserController.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$error = "";
$user = null;
$activation_token= bin2hex(random_bytes(16));
$activation_token_hash = hash ("sha256" , $activation_token);


// Create an instance of the controller
$pdo = config::getConnexion();
$userController = new UserController();
if (isset($_POST['register'])){
    $checkUSER= $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $checkUSER->execute([':username' => $_POST['username']]);
    if($checkUSER->rowCount() > 0){
        echo '<script>alert("user Already Exist!")</script>';
     
    }
    else
    {
 


if (
    isset($_POST["email"]) &&isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["birthday"]) && isset($_POST["establishment"])
) {
    if (
        !empty($_POST["email"]) &&!empty($_POST["username"]) && !empty($_POST["password"]) && !empty($_POST["birthday"]) && !empty($_POST["establishment"])
    ) {
        $user = new User(
            null,
            $_POST['email'],
            $_POST['username'],
            $_POST['password'],
            intval($_POST['birthday']),
            $_POST['establishment'],
            $activation_token_hash
        );

        // Add user
        $userController->addUser($user);
       //Mailing
       $mail = new PHPMailer(true);
       $mail->isSMTP();
       $mail->Host = 'smtp.gmail.com';
       $mail->SMTPAuth = true;
       $mail->Username = 'jihed.bakalti@gmail.com';
       $mail->Password = ''; //T7OT el APP code te3ek
       $mail->SMTPSecure = 'ssl';
       $mail->Port = 465;
       $mail->setFrom ('jihed.bakalti@gmail.com');
       $mail->addAddress($_POST["email"]);
       $mail->isHTML(true);
       $mail->Subject = " account Verification";
       $mail->Body = <<<END
        Click <a href="http://localhost/test/CHEMEL/view/BackOffice/verification.php?token=$activation_token_hash">Here</a> to activate your account.  
        END;
       $mail->send();
       echo '<script>alert("Email Verfication Sent, Check your Email!")</script>';
       header('Location:../FrontOffice/SIGNIN.php');
        // Redirect to the user list page
    } else {
        $error = "Missing information";
    }
}
}
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add User - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom CSS for centering -->
    <style>
        .centered-form {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            width: 100%;
            max-width: 500px;
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
<body id="page-top">
    <div class="container-fluid centered-form">
        <div class="card border-left-primary shadow py-4 px-4">
            <h1 class="h4 text-gray-800 mb-4 text-center">Add a User</h1>
            <form id="addUserForm" action="" method="POST" onsubmit="return validateForm();">
            <label for="email">Email:</label>
                <input class="form-control form-control-user mb-3" type="text" id="email" name="email" required>
                <span id="email_error"></span>
              
                <label for="username">Username:</label>
                <input class="form-control form-control-user mb-3" type="text" id="username" name="username" required>
                <span id="username_error"></span>

                <label for="password">Password:</label>
                <input class="form-control form-control-user mb-3" type="password" id="password" name="password" required>
                <span id="password_error"></span>

                <label for="birthday">Birthday (Year):</label>
                <input class="form-control form-control-user mb-3" type="number" id="birthday" name="birthday"required>
                <span id="birthday_error"></span>

                <label for="establishment">Establishment:</label>
                <input class="form-control form-control-user mb-3" type="text" id="establishment" name="establishment" required>
                <span id="establishment_error"></span>

                <button type="submit" class="btn btn-primary btn-user btn-block" name="register">Add User</button>
                <a href="../FrontOffice/SIGNIN.php">SIGN IN</a>
            </form>
            <?php if ($error): ?>
                <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
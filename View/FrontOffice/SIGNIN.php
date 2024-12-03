<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">

</head>

<body>

    <div class="signin-container">
        <h2>Sign In</h2>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
            </div>


            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="btn" name="signin">Sign In</button>
        </form>

        <div class="footer-text">
            <p>Don't have an account? <a href="../BackOffice/adduser.php">Sign Up</a></p>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
session_start();
include '../../controller/UserController.php';
$pdo = config::getConnexion();
if (isset($_SESSION['user'])){
    header("location: homepage.php",true);

}
if (isset($_POST['signin']))
{
    $checkUSER = $pdo->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
    $checkUSER->execute([
        ':username' => $_POST['username'],
        ':password' => $_POST['password']
    ]);
    if($checkUSER->rowCount()>0)
    {
    $checkUSER=$checkUSER->fetchObject();
    $_SESSION['user']=$checkUSER;
    header("location:homepage.php",true);

}
else{
    echo'<div class="alert alert-warning">NO User Found, Wrong Informations </div>';
}
    


}



?>

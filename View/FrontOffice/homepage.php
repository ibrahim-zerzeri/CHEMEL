<?php
session_start();
if (!(isset($_SESSION['user']))){  
    header("location:SIGNIN.php",true);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOMEPAGE</title>
</head>
<body>
    <h1>Welcome ,</h1>
    <?php
    echo $_SESSION['user']->username;
    ?>
    <a href="SIGNOUT.php">SIGN OUT</a>
    
</body>
</html>
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
    <h1>Welcome <?php
    echo $_SESSION['user']->username;
    ?></h1>
    
    <a href="SIGNOUT.php">SIGN OUT</a>
    
</body>
</html>
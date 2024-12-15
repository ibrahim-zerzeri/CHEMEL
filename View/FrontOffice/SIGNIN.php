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
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" >
            </div>


            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" >
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
include '../../Controller/BasketController.php';

$BasketController = new BasketController();

$pdo = config::getConnexion();
if (isset($_SESSION['user'])){
    $userId = $_SESSION['user']->id;
    $latestBasketId = $BasketController->getLatestBasketForUser($userId);
    
    if ($latestBasketId!==null ) {
        $quantityOfLatestBasket= $BasketController->getTotalQuantity($latestBasketId);
    $_SESSION['basket_id'] = $latestBasketId;
    $_SESSION['totalQuantity'] = $quantityOfLatestBasket;
    } else {
        $_SESSION['basket_id'] = $BasketController->createBasket($userId);
        $_SESSION['totalQuantity'] = 0;
        
    }
    header("location: index.php",true);

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
    if ($checkUSER->ban==1)
    {
        echo'<div class="alert alert-warning">ACCOUNT BANNED , CONTACT ADMINS </div>';

    }
     else if ($checkUSER->activation_token_hash!=NULL)
     {echo'<div class="alert alert-warning">COMPLETE EMAIL VERIFICATION ! </div>';}
    else {
     
    $_SESSION['user']=$checkUSER;
    $userId = $_SESSION['user']->id;
    $latestBasketId = $BasketController->getLatestBasketForUser($userId);

    if ($latestBasketId!==null) {
        $quantityOfLatestBasket= $BasketController->getTotalQuantity($latestBasketId);
    $_SESSION['basket_id'] = $latestBasketId;
    $_SESSION['totalQuantity'] = $quantityOfLatestBasket;
    } else {
        $_SESSION['basket_id'] = $BasketController->createBasket($userId);
        $_SESSION['totalQuantity'] = 0;
        
    }
    header("location:index.php",true);
}

}
else{
    echo'<div class="alert alert-warning">NO User Found, Wrong Informations </div>';
}
    


}



?>

<?php 
include '../../controller/UserController.php';
$token= $_GET["token"];

$db = config::getConnexion();
$query = $db->prepare(
    'UPDATE users SET 
        activation_token_hash= NULL
    WHERE activation_token_hash = :token'
);

$query->execute([
    'token' => $token,
    
]);

echo '<script>alert("Account Activated Successfully")</script>';
header('Location:../FrontOffice/SIGNIN.php');

    



?>
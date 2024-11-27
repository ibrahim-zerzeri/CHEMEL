<?php
include '../../controller/UserController.php';
$userC = new UserController();

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $userC->deleteUser($id);
}
header('Location: userList.php');
exit();
?>

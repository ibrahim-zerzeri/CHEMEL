<?php
include '../../controller/OrderController.php';
$order = new OrderController();
$order->deleteOrder($_GET["id"]);
header('Location:orderList.php');

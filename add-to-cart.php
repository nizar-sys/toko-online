<?php

require './database/koneksi.php';

$productId = $_POST['product_id'];
$qty = $_POST['qty'];
$user_id = $_POST['user_id'];

$sql = "INSERT INTO `tb_keranjang` VALUES ('','$user_id','$productId','$user_id','$qty', DEFAULT)";
if (mysqli_query($conn, $sql)) {
    echo json_encode(array("statusCode" => 200));
} else {
    echo json_encode(array("statusCode" => 201));
}
mysqli_close($conn);

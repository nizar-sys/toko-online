<?php

require './database/koneksi.php';

function getMyCart($id)
{
    global $conn;
    $sql = "SELECT * FROM tb_keranjang INNER JOIN tb_product ON tb_keranjang.product_id = tb_product.product_id WHERE tb_keranjang.user_id = '$id' AND tb_keranjang.is_payed = '2' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function updateCart($data)
{
    global $conn;

    $cart_id = htmlspecialchars($data['cart_id']);
    $qty = htmlspecialchars($data['qty']);

    $sql = "UPDATE `tb_keranjang` SET `qty`='$qty' WHERE keranjang_id = '$cart_id'";
    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
}

function deleteCart($id)
{
    global $conn;

    $sql = "DELETE FROM `tb_keranjang` WHERE keranjang_id = '$id'";
    mysqli_query($conn, $sql);
    return mysqli_affected_rows($conn);
}

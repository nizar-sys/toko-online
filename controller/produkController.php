<?php

require './database/koneksi.php';

function getAllProduk()
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM tb_product ORDER BY product_id DESC");
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function getProdukById($id)
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_id = '$id'");
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

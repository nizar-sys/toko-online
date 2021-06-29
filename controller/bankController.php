<?php

require './database/koneksi.php';

function getAllBank()
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM tb_bank ORDER BY bank_id DESC");
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

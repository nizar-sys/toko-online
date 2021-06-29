<?php

$conn = mysqli_connect("localhost", "root", "", "db_toko");

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function getTransaksiFilter($tgl)
{
    global $conn;
    $sql = "SELECT * FROM tb_transaksi INNER JOIN tb_user ON tb_transaksi.user_id = tb_user.user_id INNER JOIN tb_bank ON tb_transaksi.bank_id = tb_bank.bank_id INNER JOIN tb_keranjang ON tb_transaksi.keranjang_grup = tb_keranjang.keranjang_id INNER JOIN tb_product ON tb_keranjang.product_id = tb_product.product_id WHERE tanggal_transaksi = '$tgl'";
    $result = mysqli_query($conn, $sql);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


function update($data)
{
    global $conn;
    $id = $data["id"];
    $product_name = htmlspecialchars($data["nama_produk"]);
    $product_price = htmlspecialchars($data["harga_produk"]);
    $product_description = htmlspecialchars($data["desc_produk"]);
    $stock_product = htmlspecialchars($data["stok_produk"]);
    $gambar_lama = htmlspecialchars($data["gambar_lama"]);

    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambar_lama;
    } else {
        $gambar = upload();
    }


    $query = "UPDATE `tb_product` SET `product_name`='$product_name',`product_desc`='$product_description',`product_thumb`='$gambar',`product_stok`='$stock_product',`product_price`='$product_price' WHERE product_id = '$id'";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
// upload func
function upload()
{

    $nama_file = $_FILES['gambar']['name'];
    $ukuran_file = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmp_name = $_FILES['gambar']['tmp_name'];

    if ($error === 4) {
        echo "<script>
                window.location.href = './?response=imgfail';
			</script>";
        return false;
    }

    $ekstensi_gambar_valid = ['jpg', 'jpeg', 'png', 'jfif'];
    $ekstensi_gambar = explode('.', $nama_file);
    $ekstensi_gambar = strtolower(end($ekstensi_gambar));
    if (!in_array($ekstensi_gambar, $ekstensi_gambar_valid)) {
        echo "<script>
                window.location.href = './?response=imgwarning';
			</script>";
        return false;
    }

    if ($ukuran_file > 1000000) {
        echo "<script>
            window.location.href = './?response=imgover';
		</script>";
        return false;
    }

    $nama_file_baru = uniqid();
    $nama_file_baru .= '.';
    $nama_file_baru .= $ekstensi_gambar;

    move_uploaded_file($tmp_name, '../../img/' . $nama_file_baru);

    return $nama_file_baru;
}

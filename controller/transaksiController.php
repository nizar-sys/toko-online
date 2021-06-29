<?php

require './database/koneksi.php';

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
function getAllTransaksi()
{
    global $conn;
    $result = mysqli_query($conn, "SELECT * FROM tb_transaksi ORDER BY transaksi_id DESC");
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function addTransaksi($data)
{
    global $conn;

    $user_id = $data['user_id'];
    $bank_id = $data['bank_id'];
    $keranjang_id = $data['keranjang_id'];
    $keranjang_grup = $data['keranjang_grup'];
    $alamat_pembeli = htmlspecialchars($data['alamat_pembeli']);
    $tglTransaksi = date('Y-m-d');

    $sql = "UPDATE `tb_keranjang` SET `is_payed`='1' WHERE tb_keranjang.keranjang_grup = '$keranjang_grup'";

    if ($bank_id === "0") {
        echo "<script>
            window.location.href = './checkout?r=bankfalse'
        </script>";
        return false;
    }

    mysqli_query($conn, $sql);
    if (mysqli_affected_rows($conn) > 0) {
        mysqli_query($conn, "INSERT INTO `tb_transaksi`(`transaksi_id`, `user_id`, `bank_id`, `keranjang_grup`, `transaksi_alamat`, `tanggal_transaksi`, `status_pembayaran`, `bukti_pembayaran`) VALUES ('','$user_id','$bank_id','$keranjang_id','$alamat_pembeli','$tglTransaksi',DEFAULT,DEFAULT)");
        return mysqli_affected_rows($conn);
    }
}

function getTransaksiByUserId($id)
{
    global $conn;
    $sql = "SELECT * FROM tb_transaksi INNER JOIN tb_user ON tb_transaksi.user_id = tb_user.user_id INNER JOIN tb_bank ON tb_transaksi.bank_id = tb_bank.bank_id INNER JOIN tb_keranjang ON tb_transaksi.keranjang_grup = tb_keranjang.keranjang_id INNER JOIN tb_product ON tb_keranjang.product_id = tb_product.product_id";
    $result = mysqli_query($conn, $sql);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


function konfirmPayment($data)
{
    global $conn;

    $product_id = htmlspecialchars($data["product_id"]);
    $transaksi_id = htmlspecialchars($data["transaksi_id"]);
    $qty = $data['qty'];

    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    $db_product = query("SELECT * FROM tb_product WHERE product_id = '$product_id'")[0];
    $db_stok_product = $db_product['product_stok'];

    $newStok = intval($db_stok_product) - intval($qty);

    $total_harga = intval($db_product['product_price']) * intval($qty);

    $sql = "UPDATE `tb_product` SET `product_stok`='$newStok' WHERE product_id = '$product_id'";
    if (mysqli_query($conn, $sql)) {
        mysqli_query($conn, "UPDATE `tb_transaksi` SET `status_pembayaran`='1',`bukti_pembayaran`='$gambar', `total_pembayaran`='$total_harga' WHERE transaksi_id = '$transaksi_id'");
        return mysqli_affected_rows($conn);
    }
}



function upload()
{

    $nama_file = $_FILES['gambar']['name'];
    $ukuran_file = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmp_name = $_FILES['gambar']['tmp_name'];

    if ($error === 4) {
        echo "<script>
				alert ('pilih gambar terlebih dahulu');
			</script>";
        return false;
    }

    $ekstensi_gambar_valid = ['jpg', 'jpeg', 'png'];
    $ekstensi_gambar = explode('.', $nama_file);
    $ekstensi_gambar = strtolower(end($ekstensi_gambar));
    if (!in_array($ekstensi_gambar, $ekstensi_gambar_valid)) {
        echo "<script>
				alert ('yang anda upload bukan gambar');
			</script>";

        return false;
    }

    if ($ukuran_file > 1000000) {
        echo "<script>
				alert ('ukuran gambar terlalu besar');
			</script>";
    }

    $nama_file_baru = uniqid();
    $nama_file_baru .= '.';
    $nama_file_baru .= $ekstensi_gambar;

    move_uploaded_file($tmp_name, 'img/' . $nama_file_baru);

    return $nama_file_baru;
}

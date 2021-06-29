<?php
session_start();

if (!isset($_SESSION['login'])) {
    header('Location; ../');
    exit;
}
require './produk_function.php';

$id = (isset($_GET['id'])) ? $_GET['id'] : null;
$respon = (isset($_GET['response'])) ? $_GET['response'] : null;
$hapus = (isset($_GET['hapus'])) ? $_GET['hapus'] : null;
$modal = (isset($_GET['modal'])) ? $_GET['modal'] : null;


if ($respon === "deletesuccess") {
    $respon = "Data produk berhasil dihapus!";
} elseif ($respon === "deletefalse") {
    $respon = "Data produk gagal dihapus!";
} elseif ($respon === "successadd") {
    $respon = "Data produk berhasil ditambah!";
} elseif ($respon === "failadd") {
    $respon = "Data produk gagal ditambah!";
} elseif ($respon === "imgfail") {
    $respon = "Anda belum pilih gambar produk!";
} elseif ($respon === "imgwarning") {
    $respon = "Yang Anda upload bukan gambar!";
} elseif ($respon === "imgover") {
    $respon = "Ukuran gambar terlalu besar!";
} elseif ($respon === "error") {
    $respon = "Anda belum pilih kategori!";
} elseif ($respon === "updatesuccess") {
    $respon = "Berhasil ubah data produk!";
} elseif ($respon === "updatefalse") {
    $respon = "Gagal ubah data produk!";
}


$produk = query("SELECT * FROM tb_product");

if ($id != null) {
    $productId = query("SELECT * FROM tb_product WHERE product_id = '$id'")[0];
}


if ($hapus === "true") {
    if (delete($id) > 0) {
        echo "
			<script>
				document.location.href = './?response=deletesuccess';
			</script>
		";
    } else {
        echo "
			<script>
				document.location.href = './?response=deletefalse';
			</script>
		";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Hind+Vadodara:wght@300;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <title>Toko Media | Admin Dashboard</title>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="header-logo">
                <span class="site-title">Toko Media</span>
            </div>
            <div class="header-search">
                <button class="button-menu">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
        <div class="main">
            <div class="sidebar">
                <ul>
                    <li><a href="../"><span>Dashboard</span></a></li>
                    <li><a href="./" class="active"><span>Data Produk</span></a></li>
                    <li><a href="../data-laporan/"><span>Laporan</span></a></li>
                    <li><a href="../../auth/logout"><span>Logout</span></a></li>
                </ul>
            </div>
            <div class="page-content">
                <?php if ($respon) : ?>
                    <div class="alert" style="margin-bottom: 1rem;">
                        <a style="float: right;" href="./"><i class="fas fa-times"></i></a>
                        <strong><?= $respon ?></strong>
                    </div>
                <?php endif; ?>
                <a href="./tambah-produk"><i class="fas fa-plus"></i> Tambah Barang</a>
                <table>
                    <tr>
                        <th>Nama Produk</th>
                        <th>Deskripsi Product</th>
                        <th>Gambar Produk</th>
                        <th>Harga Produk</th>
                        <th>Stok Produk</th>
                        <th>Aksi</th>
                    </tr>
                    <?php foreach ($produk as $produk) : ?>
                        <tr>
                            <td><?= $produk['product_name'] ?></td>
                            <td><?= $produk['product_desc'] ?></td>
                            <td><img src="../../img/<?= $produk['product_thumb'] ?>" style="width: 100px;"></td>
                            <td><?= $produk['product_price'] ?></td>
                            <td><?= $produk['product_stok'] ?></td>
                            <td>
                                <a href="./update-produk?id=<?= $produk['product_id'] ?>"><i class="fas fa-edit"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <?php if ($produk === []) : ?>
                    <h3>Data Kosong</h3>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/6d2ea823d0.js"></script>
    <script src="../main.js"></script>
</body>

</html>
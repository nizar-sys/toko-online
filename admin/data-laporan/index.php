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


if (isset($_POST['tampilkan'])) {
    $tgl_awal = $_POST['tgl_awal'];
    $myTransaksi = getTransaksiFilter($tgl_awal);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.25/datatables.min.css" />
    <link rel="stylesheet" href="../style.css">
    <title>Toko Media | Admin Dashboard</title>
</head>

<body>
    <div class="uwucontainer">
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
                    <li><a href="../data-produk"><span>Data Produk</span></a></li>
                    <li><a href="./" class="active"><span>Laporan</span></a></li>
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
                <h4>Detail Transaksi</h4>

                <form action="" method="post">

                    <input type="date" name="tgl_awal" id="tgl_akhir">
                    <input type="date" name="tgl_akhir" id="tgl_akhir">
                    <input type="submit" name="tampilkan" id="tampilkan" class="btn btn-success" value="Tampilkan">

                </form>

                <?php if (isset($_POST['tampilkan'])) : ?>
                    <a href="./cetak.php?tgl=<?= $tgl_awal ?>" class="btn btn-success">Import ke excel</a>
                    <table id="tabel-data" class="table table-striped table-bordered text-center" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Sub total</th>
                                <th>Nama Pembeli</th>
                                <th>Alamat Pembeli</th>
                                <th>Status Pembayaran</th>
                                <th>Tanggal Pesan</th>
                                <th>Transfer Ke</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total = 0; ?>
                            <?php foreach ($myTransaksi as $myTransaksi) : ?>
                                <tr>
                                    <td><?= $myTransaksi['product_name'] ?></td>
                                    <td>Rp.<?= number_format($myTransaksi['product_price'], 0, ',', '.') ?></td>
                                    <td><?= $myTransaksi['qty'] ?></td>
                                    <?php
                                    $sub_total = intval($myTransaksi['product_price']) * intval($myTransaksi['qty']);
                                    $sub_total2 = number_format($sub_total, 0, ',', '.');
                                    ?>
                                    <td>Rp.<?= $sub_total2 ?></td>
                                    <td><?= $myTransaksi['fullname'] ?></td>
                                    <td><?= $myTransaksi['transaksi_alamat'] ?></td>
                                    <?php if ($myTransaksi['status_pembayaran'] === "2") { ?>
                                        <td>Belum dibayar</td>
                                    <?php } else { ?>
                                        <td>Selesai dibayar</td>
                                    <?php } ?>
                                    <td><?= $myTransaksi['tanggal_transaksi'] ?></td>
                                    <td><?= $myTransaksi['no_bank'] ?></td>
                                </tr>

                                <?php $total += intval($sub_total); ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <h3>Total Pendapatan Rp. <?= number_format($total, 0, ',', '.') ?></h3>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity=<script src="https://kit.fontawesome.com/6d2ea823d0.js"></script>
    <script src="../main.js"></script>
    <script>
        $(document).ready(function() {
            $('#tabel-data').DataTable();
        });
    </script>
</body>

</html>
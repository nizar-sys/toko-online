<?php
session_start();

require './database/koneksi.php';
require './controller/transaksiController.php';

// url get
$response = (isset($_GET['r'])) ? $_GET['r'] : null;

if ($response === "success") {
    $response = "Bukti pembayaran berhasil dikirim, terimakasih";
} elseif ($response === "false") {
    $response = "Maaf, bukti pembayaran gagal dikirim";
}
if (isset($_SESSION['login'])) {
    $user_id = $_SESSION['dataUser']['user_id'];
    $fullname = $_SESSION['dataUser']['fullname'];
}

$myTransaksi = getTransaksiByUserId($user_id);
if (isset($_POST['konfirmasi-pembayaran'])) {
    if (konfirmPayment($_POST) > 0) {
        echo "
                <script>
                    document.location.href = './detail-transaksi?r=success';
                </script>
            ";
    } else {
        echo "<script>
                    document.location.href = './detail-transaksi?r=false';
                </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <!-- meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- title -->
    <title>Toko Media</title>

    <!-- css -->

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.25/datatables.min.css" />



</head>

<body id="home">

    <!-- navbar -->
    <nav class="navbar-container sticky-top">
        <div class="navbar-logo">
            <h3><a href="./">Toko Media</a></h3>
        </div>
        <div class="navbar-box">
            <ul class="navbar-list">
                <li><a href="./"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="./shop"><i class="fas fa-shopping-cart"></i> Shop</a></li>
                <?php if (!isset($_SESSION['login'])) { ?>
                    <li><a href="./auth/login"><i class="fas fa-lock"></i> Signin</a></li>
                <?php } else { ?>
                    <li><a href="./my-cart"><i class="fas fa-shopping-cart"></i> My Cart</a></li>
                    <li><a href="./auth/logout"><i class="fas fa-lock"></i> Logout</a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="navbar-toggle">
            <span></span>
        </div>
    </nav>
    <!-- akhir navbar -->

    <!-- mycart -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <?php if ($response) : ?>
                    <div class="alert alert-costum mt-2 alert-dismissible fade show" id="success" style="background-color: #4a1667; color: white;" role="alert" data-aos="fade-left" data-aos-delay="500">
                        <strong><?= $response ?></strong>
                        <button type="button" class="close" id="close-alert">
                            <a href="./detail-transaksi"><i class="fas fa-times"></i></a>
                        </button>
                    </div>
                <?php endif; ?>
                <table id="tabel-data" class="table table-striped table-bordered text-center" width="100%" cellspacing="0">
                    <h4>Detail Transaksi</h4>
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
                            <th>Aksi</th>
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
                                <?php if ($myTransaksi['status_pembayaran'] === "2") { ?>
                                    <td>
                                        <p data-toggle="modal" data-target="#exampleModal" data-total_price="<?= $total ?>" id="konfirmasi_pembayaran" data-qty="<?= $myTransaksi['qty'] ?>" data-product_id="<?= $myTransaksi['product_id'] ?>" data-transaksi_id="<?= $myTransaksi['transaksi_id'] ?>"><i class="fas fa-money-bill-wave-alt"></i></p>
                                    </td>
                                <?php } else { ?>
                                    <td></td>
                                <?php } ?>
                            </tr>

                            <?php $total += intval($sub_total); ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <h3>Total Rp. <?= number_format($total, 0, ',', '.') ?></h3>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Pembayaran</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <input type="hidden" name="transaksi_id" id="transaksi_id">
                                <input type="hidden" name="qty" id="qty">
                                <input type="hidden" name="product_id" id="product_id">
                                <input type="hidden" name="total_harga" id="total_harga">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Bukti Pembayaran</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" name="gambar" class="custom-file-input" id="inputGroupFile01">
                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" name="konfirmasi-pembayaran" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- mycart end -->

    <!-- footer -->
    <section class="footer bg-dark" id="contact">
        <div class="footer-content">

            <div class="row">
                <div class="col-md-5 my-3 mx-auto" data-aos="fade-in">
                    <h4 class="text-light text-poppins font-weight-bold">Useful Links</h4>
                    <div class="d-flex flex-column">
                        <a href="#home" class="text-light font-weight-light">Home</a>
                        <a href="#shop" class="text-light font-weight-light">Shop</a>
                    </div>
                </div>
                <div class="col-md-5 my-3 mx-auto" data-aos="fade-in">
                    <h4 class="text-light text-poppins font-weight-bold">Toko Media</h4>
                    <p class="d-block font-weight-light text-light">
                        Toko Media adalah aplikasi berbelanja online dengan fasilitas memadai
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="d-flex justify-content-center align-items-center text-center flex-column mx-auto">
                        <span class="d-block text-light">© Copyright <strong>2021</strong>. All Right Reserved</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- akhir footer -->

    <!-- javascript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="assets/js/script.js"></script>

    <script>
        $(document).ready(function() {
            $('#tabel-data').DataTable();

            $("#konfirmasi_pembayaran").click(function(e) {
                e.preventDefault();
                let transaksi_id = $(this).data('transaksi_id');
                let qty = $(this).data('qty');
                let product_id = $(this).data('product_id');

                $('#transaksi_id').val(transaksi_id)

                $('#qty').val(qty)
                $('#product_id').val(product_id)

            });
        });
    </script>
</body>

</html>
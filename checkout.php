<?php
session_start();

require './database/koneksi.php';
require './controller/cartController.php';
require './controller/bankController.php';
require './controller/transaksiController.php';

if (isset($_SESSION['login'])) {
    $user_id = $_SESSION['dataUser']['user_id'];
    $fullname = $_SESSION['dataUser']['fullname'];
}

$myCart = getMyCart($user_id);
// var_dump($myCart);
// die;
$bank = getAllBank();

// url get
$response = (isset($_GET['r'])) ? $_GET['r'] : null;
$cart_id = (isset($_GET['cart-id'])) ? $_GET['cart-id'] : null;

// flash msg
if ($response === "trxsuccess") {
    $response = "Transaksi success";
} elseif ($response === "trxfailed") {
    $response = "Transaksi failed";
} elseif ($response === "bankfalse") {
    $response = "Please choose payment method";
}

if (isset($_POST['tambah-transaksi'])) {
    if (addTransaksi($_POST) > 0) {
        echo "<script>
        window.location.href = './detail-transaksi'
      </script>";
    } else {
        echo "<script>
        window.location.href = './my-cart?r=trxfailed'
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
        <?php if ($response) : ?>
            <div class="alert alert-costum mt-2 alert-dismissible fade show" id="success" style="background-color: #4a1667; color: white;" role="alert" data-aos="fade-left" data-aos-delay="500">
                <strong><?= $response ?></strong>
                <button type="button" class="close" id="close-alert">
                    <a href="./checkout"><i class="fas fa-times"></i></a>
                </button>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-6">
                <form action="" method="post">
                    <input type="hidden" name="user_id" id="user_id" value="<?= $user_id ?>">
                    <input type="hidden" name="keranjang_id" id="keranjang_id" value="<?= $cart_id ?>">
                    <input type="hidden" name="keranjang_grup" id="keranjang_grup" value="<?= $user_id ?>">
                    <label for="nama_pembeli">Nama lengkap</label>
                    <input type="text" name="nama_pembeli" id="nama_pembeli" class="form-control" value="<?= $fullname ?>">

                    <label for="alamat_pembeli">Alamat lengkap</label>
                    <input type="text" name="alamat_pembeli" id="alamat_pembeli" class="form-control" required>

                    <div class="input-group mt-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="inputGroupSelect01">Pembayaran</label>
                        </div>
                        <select name="bank_id" class="custom-select" id="inputGroupSelect01" required>
                            <option selected value="0">Pilih Pembayaran</option>
                            <?php foreach ($bank as $bank) : ?>
                                <option value="<?= $bank['bank_id'] ?>"><?= $bank['nama_bank'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button name="tambah-transaksi" class="btn btn-success mt-2">Tambah Pesanan</button>
                </form>
            </div>
            <div class="col-md-6">
                <table id="tabel-data" class="table table-striped table-bordered text-center" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Stok</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Sub total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0; ?>
                        <?php foreach ($myCart as $myCart) : ?>
                            <tr>
                                <td><?= $myCart['product_name'] ?></td>
                                <td><?= $myCart['product_stok'] ?></td>
                                <td>Rp.<?= number_format($myCart['product_price'], 0, ',', '.') ?></td>
                                <td><?= $myCart['qty'] ?></td>
                                <?php
                                $sub_total = intval($myCart['product_price']) * intval($myCart['qty']);
                                $sub_total2 = number_format($sub_total, 0, ',', '.');
                                ?>
                                <td>Rp.<?= $sub_total2 ?></td>
                            </tr>
                            <?php $total += intval($sub_total) ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <h3>Total Rp. <?= number_format($total, 0, ',', '.') ?></h3>
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
        });
    </script>
</body>

</html>
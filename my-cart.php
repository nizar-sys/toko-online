<?php
session_start();

require './database/koneksi.php';
require './controller/cartController.php';

if (isset($_SESSION['login'])) {
  $user_id = $_SESSION['dataUser']['user_id'];
}

$myCart = getMyCart($user_id);

if (isset($_POST['update'])) {
  if (updateCart($_POST) > 0) {
    echo "<script>
      window.location.href = './my-cart?r=updatesuccess'
    </script>";
  } else {
    echo "<script>
      window.location.href = './my-cart?r=updatefailed'
    </script>";
  }
}

if (isset($_POST['delete'])) {
  $id = $_POST['cart_id'];
  if (deleteCart($id)) {
    echo "<script>
      window.location.href = './my-cart?r=deletesuccess'
    </script>";
  } else {
    echo "<script>
      window.location.href = './my-cart?r=deletefailed'
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
      <div class="col-md-2">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Menu</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row"><a href="./detail-transaksi">Pesanan Saya</a></th>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col-md-10">
        <table id="tabel-data" class="table table-striped table-bordered text-center" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Product</th>
              <th>Stok</th>
              <th>Harga</th>
              <th>Qty</th>
              <th>Sub total</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $total = 0; ?>
            <?php foreach ($myCart as $myCart) : ?>
              <tr>
                <td><?= $myCart['product_name'] ?></td>
                <td><?= $myCart['product_stok'] ?></td>
                <td>Rp.<?= number_format($myCart['product_price'], 0, ',', '.') ?></td>
                <form action="" method="post">
                  <td>
                    <input type="hidden" name="cart_id" id="cart_id" value="<?= $myCart['keranjang_id'] ?>">
                    <input type="number" name="qty" id="qty" class="form-control" value="<?= $myCart['qty'] ?>">
                  </td>
                  <?php
                  $sub_total = intval($myCart['product_price']) * intval($myCart['qty']);
                  $sub_total2 = number_format($sub_total, 0, ',', '.');
                  ?>
                  <td>Rp.<?= $sub_total2 ?></td>
                  <td>
                    <button class="btn btn-warning" id="update" name="update"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger" id="delete" name="delete"><i class="fas fa-trash"></i></button>
                  </td>
                </form>
              </tr>
              <?php $total += intval($sub_total) ?>
          </tbody>
        </table>
        <a href="./checkout?cart-id=<?= $myCart['keranjang_id'] ?>" class="btn btn-success float-right">CheckOut</a>
      <?php endforeach; ?>
      <h3>Total Rp. <?= number_format($total, 0, ',', '.') ?></h3>
      </div>
    </div>
  </div>
  <!-- mycart end -->

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
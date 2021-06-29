<?php
session_start();
require './controller/produkController.php';

$product = getAllProduk();

if (isset($_SESSION['login'])) {
  $user_id = $_SESSION['dataUser']['user_id'];
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

</head>

<body id="home">

  <!-- navbar -->
  <nav class="navbar-container">
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

  <!-- all product -->
  <section class="product" id="shop">
    <div class="product-content">
      <div class="alert alert-costum mt-2 alert-dismissible fade show" id="success" style="background-color: #4a1667; color: white;" role="alert" data-aos="fade-left" data-aos-delay="500">
        <strong>Berhasil!</strong> Produk berhasil disimpan di keranjang
        <button type="button" class="close" id="close-alert">
          <span><i class="fas fa-times"></i></span>
        </button>
      </div>
      <div class="row">
        <?php foreach ($product as $product) : ?>
          <div class="col-md-4" data-aos="zoom-in">
            <div class="card-custom">
              <div class="card-custom-header">
                <img src="assets/img/<?= $product['product_thumb'] ?>" alt="" class="img-custom">
              </div>
              <div class="card-custom-body d-flex justify-content-between">
                <div class="card-custom-text my-auto">
                  <h4 class="m-0"><?= $product['product_name'] ?></h4>
                  <span class="d-block font-weight-bold mb-3">Rp.<?= $product['product_price'] ?></span>
                </div>
                <?php if (isset($_SESSION['login'])) { ?>
                  <p onclick="addToCart(<?= $product['product_id'] ?>, 1, <?= $user_id ?>)" style="cursor: pointer;" class="button button-purple my-4"><i class="fas fa-shopping-cart"></i> Add to cart</p>
                <?php } else { ?>
                  <a href="./auth/login" class="button button-purple my-4"><i class="fas fa-lock"></i> Signin to order</a>
                <?php } ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
  <!-- akhir all product -->

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

  <!-- <script src="https://kit.fontawesome.com/6d2ea823d0.js"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script src="assets/js/script.js"></script>

  <script>
    $('#success').hide();
    $('#close-alert').on('click', () => {
      $('#success').hide();
    })
    // ajax add to cart
    function addToCart(productId, qty, user_id) {
      $.ajax({
        url: 'add-to-cart.php',
        method: 'post',
        data: {
          product_id: productId,
          user_id: user_id,
          qty: qty
        },
        cache: false,
        success: function(res) {
          let result = JSON.parse(res);
          console.log(result)
          if (result.statusCode === 200) {
            window.location.href = './my-cart'
          } else {
            $('#success').hide()
          }
        }
      })
    }
  </script>

</body>

</html>
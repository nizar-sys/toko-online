<?php

session_start();

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

  <section class="header">
    <div class="header-content">
      <div class="row">
        <div class="col-md-5 my-auto mx-auto" data-aos="fade-right">
          <h2>Toko Media</h2>
          <p>
            Toko Media adalah aplikasi belanja online terbesar di Indonesia.
            Dengan memiliki fasilitas & pengiriman cepat
          </p>
          <a href="./shop" class="button button-purple">Belanja Sekarang</a>
        </div>
        <div class="col-md-6 my-auto mx-auto" data-aos="zoom-in">
          <div class="d-flex justify-content-center align-items-center flex-column">
            <img src="assets/img/baju.jfif" alt="banner" class="my-5">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- footer -->
  <section class="footer bg-dark" id="contact">
    <div class="footer-content">

      <div class="row">
        <div class="col-md-5 my-3 mx-auto" data-aos="fade-in">
          <h4 class="text-light text-poppins font-weight-bold">Useful Links</h4>
          <div class="d-flex flex-column">
            <a href="#home" class="text-light font-weight-light">Home</a>
            <a href="./shop" class="text-light font-weight-light">Shop</a>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
  <script src="assets/js/script.js"></script>

</body>

</html>
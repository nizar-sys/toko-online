<?php

require '../database/koneksi.php';
require '../controller/authController.php';

// url get
$response = (isset($_GET['response'])) ? $_GET['response'] : null;

// flash msg
if ($response === "usnfalse") {
    $response = "Username has already been created, please login or create a new username";
} elseif ($response === "passfalse") {
    $response = "Password dont matched";
} elseif ($response === "signupsuccess") {
    $response = "Sign up success, please Login";
} elseif ($response === "signupfalse") {
    $response = "Sign up false,please try again later";
}

if (isset($_POST['register'])) {
    if (registrasi($_POST) > 0) {
        echo "<script>
            window.location.href = './register?response=signupsuccess';
        </script>";
    } else {
        echo "<script>
                window.location.href = './register?response=signupfalse';
            </script>";
    }
}


?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.min.css">

    <link rel="stylesheet" href="style.css">

    <title>Toko Media | Sign Up</title>
</head>

<body>

    <div class="global-container">
        <div class="card login-form">
            <div class="card-body">
                <h3 class="card-title text-center">Toko Media</h3>
                <div class="card-text">
                    <?php if ($response) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><?= $response ?>!</strong>
                            <button type="button" class="close" id="close-alert">
                                <a href="./register"><i class="fas fa-times"></i></a>
                            </button>
                        </div>
                    <?php endif; ?>

                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="fullname">New Fullname</label>
                            <input type="text" name="fullname" class="form-control form-control-sm" id="fullname">
                        </div>
                        <div class="form-group">
                            <label for="username">New Username</label>
                            <input type="text" name="username" class="form-control form-control-sm" id="username">
                        </div>
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" name="password" class="form-control form-control-sm" id="password">
                        </div>
                        <div class="form-group">
                            <label for="password2">Confirm Password</label>
                            <input type="password" name="password2" class="form-control form-control-sm" id="password">
                        </div>
                        <button type="submit" name="register" class="btn btn-primary btn-block">Sign Up</button>

                        <div class="sign-up">
                            Have an account? <a href="./login">Sign In</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>
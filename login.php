<?php

  session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./style/login.css?v=<?php echo time(); ?>">
    <script src='main.js'></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Telefon Dünyası</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Ana Sayfa</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="./kayit-ol.php">Kayıt Ol</a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="./login.php">Giriş Yap</a>
              </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Markalar
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="nav-bar-product-display.php?brand=Apple">Iphone</a>
                <a class="dropdown-item" href="nav-bar-product-display.php?brand=Samsung">Samsung</a>
                <a class="dropdown-item" href="nav-bar-product-display.php?brand=Xiaomi">Xiaomi</a>
                <a class="dropdown-item" href="nav-bar-product-display.php?brand=Huawei">Huawei</a>
              </div>
            </li>

            <form action='search-page.php' method="GET" class="form-inline my-0 my-lg-0">
                <input class="form-control mr-sm-2" name="search-value-input" type="search" placeholder="Ara..." aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Ara</button>
            </form>
          </ul>
        </div>
    </nav>

    <br><br><br><br><br>


    <div id="login-form-body" class="container-fluid">
        <h1>Giriş Yap</h1>

        <br><br>

        <form method="POST" id="login-form">
            <div class="form-group">
              <input type="email" class="form-control" name="email-input" id="email-input" aria-describedby="emailHelp" placeholder="Email">
            </div>
            <br><br>
            <div class="form-group">
              <input type="password" class="form-control" name="password-input" id="password-input" placeholder="Şifre">
            </div>
            <br>
            <div id="button-div" class="container-fluid"><button type="submit" class="btn btn-primary">Giriş Yap</button></div>
        </form>
    </div>

    <div id="no-account-div" class="container-fluid">
        <p>Hesabın Yok Mu ?</p>
        <a href="kayit-ol.php">Kayıt Ol</a>
    </div>
</body>
</html>





<?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

          // Database bağlantısı
          $conn = new mysqli("localhost", "root", "", "phpprojesidatabase");

          if ($conn->connect_error) {
              echo "<script>alert('DB bağlanamadı!')</script>";
          }

        // Input verilerinin alınması
          $Email_Input = $_POST['email-input'];
          $Password_Input = $_POST['password-input'];

        // Emaili ve passwordu kullanan kaç tane kullanıcı var 
        $user_count = $conn->query("SELECT COUNT(*) as user_count FROM users WHERE email_address='$Email_Input' AND password_value='$Password_Input'");

        if ($user_count->num_rows > 0) {
            while ($row = $user_count->fetch_assoc()) {
                // Eğer kullanıcı varsa kullanıcıyı ana sayfaya yönlendir
                $user_count_value = $row['user_count'];

                if ($user_count_value == 1) {
                  
                  $_SESSION['email']=$Email_Input;
                  
                  echo "<script>window.location.href='ana-sayfa.php'</script>";
                  exit(); 

                } else {
                    echo "<script>alert('Girilen değerlerde kullanıcı bulunamadı')</script>";
                }
            }
        }
    }
?>
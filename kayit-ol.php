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
    <link rel="stylesheet" href="style/login.css?v=<?php echo time(); ?>">
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
        <h1>Kayıt Ol</h1>

        <br><br>

        <form method="POST" id="login-form">
            <div class="form-group">
              <input type="text" class="form-control" name="name-input" id="name-input" aria-describedby="emailHelp" placeholder="İsim">
            </div>
            <br><br>
            <div class="form-group">
              <input required type="text" class="form-control" name="surname-input" id="surname-input" aria-describedby="emailHelp" placeholder="Soyisim">
            </div>
            <br><br>
            <div class="form-group">
              <input required type="email" class="form-control" name="email-input" id="email-input" aria-describedby="emailHelp" placeholder="Email">
            </div>
            <br><br>
            <div class="form-group">
              <input required type="text" class="form-control" name="phone-input" id="phone-input" aria-describedby="emailHelp" placeholder="Telefon">
            </div>
            <br><br>
            <div class="form-group">
              <input required type="date" class="form-control" name="dob-input" id="dob-input" aria-describedby="emailHelp" placeholder="Doğum Tarihi">
            </div>
            <br><br>
            <div class="form-group">
              <input required type="password" class="form-control" name="password-input" id="password-input" placeholder="Şifre">
            </div>
            <br>
            <div id="button-div" class="container-fluid"><button type="submit" class="btn btn-primary">Kayıt Ol</button></div>
        </form>
    </div>

    <div id="no-account-div" class="container-fluid">
        <p>Zaten Üye Misin ?</p>
        <a href="login.php">Giriş Yap</a>
    </div>
</body>
</html>



<?php

    if($_SERVER['REQUEST_METHOD']=="POST"){

        // Database bağlantısı
        $conn = new mysqli("localhost", "root", "", "phpprojesidatabase");

        if ($conn->connect_error) {
            echo "<script>alert('DB bağlanamadı!')</script>";
        }


        // Input verilerinin alınması
        $name_input=$_POST['name-input'];
        $surname_input=$_POST['surname-input'];
        $email_input=$_POST['email-input'];
        $phone_input=$_POST['phone-input'];
        $password_input=$_POST['password-input'];
        $dob_input=$_POST['dob-input'];

        //Aynı emaile sahip bir kullanıcı var mı kontrolü
        $email_count=$conn->query("SELECT COUNT(*) as email_count FROM users WHERE email_address='$email_input'");

        if($email_count->num_rows>0){

            while($row = $email_count->fetch_assoc()){

                $email_count_value = $row['email_count'];

                if($email_count_value==1){

                    echo "<script>alert('Bu Emaile Sahip Bir Kullanıcı Bulunmaktadır.')</script>";
                }
                else{

                    //Aynı Telefon numarasına sahip bir kullanıcı var mı diye kontrol etme
                    $phone_count=$conn->query("SELECT COUNT(*) as phone_count FROM users WHERE phone_number='$phone_input'");

                    if($row_2=$phone_count->fetch_assoc()){

                        $phone_count_value=$row_2['phone_count'];

                        if($phone_count_value==1){
                            echo "<script>alert('Bu Telefona Sahip Bir Kullanıcı Bulunmaktadır.')</script>";
                        }

                        else{

                            //Insert işlemi
                            $sql="INSERT INTO `users`(`user_id`, `first_name`, `last_name`, `email_address`, `password_value`, `phone_number`, `shipping_address`, `billing_address`, `city`, `state_region`, `postal_code`, `date_of_birth`, `shopping_cart`, `Cardnumber`, `Cardname`, `CVC`) VALUES ('[value-1]','$name_input','$surname_input','$email_input','$password_input','$phone_input','','','','','','$dob_input','','','','')";

                            if($conn->query($sql)===TRUE){
                                echo "<script>alert('Kayıt tamamlandı!')</script>";
                            }
                        }
                    }
                }
            }
        }
    }
?>


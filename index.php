<?php

  session_start();

  $_SESSION['email']="";//Çıkış yapıldığında session'ın içini boşaltacak

  // Database bağlantısı
  $conn = new mysqli("localhost", "root", "", "phpprojesidatabase");

  if ($conn->connect_error) {
      echo "<script>alert('DB bağlanamadı!')</script>";
  }


    //Apple ürünlerinin çekilmesi

    //Apple ürün bilgilerini çek ve bir array içine splitle;Sonra for döngüsü ile product card ile bastır
    $apple_products=$conn->query("SELECT GROUP_CONCAT(product_id) as product_ids,GROUP_CONCAT(product_name) as product_names,GROUP_CONCAT(price) as product_prices,GROUP_CONCAT(DiscountPercentage) as discount_percentages FROM products WHERE brand='Apple'");

    if($row=$apple_products->fetch_assoc()){
        
        $ProductIDs=$row['product_ids'];
        $ProductNames=$row['product_names'];
        $ProductPrices=$row['product_prices'];
        $ProductDiscounts=$row['discount_percentages'];

        $AppleProductIDArray=explode(",",$ProductIDs);
        $AppleProductNameArray=explode(",",$ProductNames);
        $AppleProductPriceArray=explode(",",$ProductPrices);
        $AppleProductDiscountArray=explode(",",$ProductDiscounts);

        $AppleProductsDiscountedPricesArray=array();

        
        //İndirimli Fiyatları Hesaplama
        
        for ($i = 0; $i < count($AppleProductIDArray); $i++) {
          $AppleOriginalPrice = (float)$AppleProductPriceArray[$i];
          $AppleDiscountPercentage = (float)$AppleProductDiscountArray[$i]; 
          $AppleDiscountedPrice = $AppleOriginalPrice - ($AppleOriginalPrice * ($AppleDiscountPercentage / 100)); 
          array_push($AppleProductsDiscountedPricesArray, $AppleDiscountedPrice);
        }

    }



    //İndirimli Ürünlerin Çekilmesi
    $discounted_products=$conn->query("SELECT GROUP_CONCAT(product_id) as product_ids, GROUP_CONCAT(product_name) as product_names, GROUP_CONCAT(price) as product_prices, GROUP_CONCAT(DiscountPercentage) as discount_percentages FROM (SELECT * FROM products WHERE DiscountPercentage != 0 LIMIT 3) as limited_products");

    if($row_2=$discounted_products->fetch_assoc()){

        $DiscountedProductsProductIDs=$row_2['product_ids'];
        $DiscountedProductsProductNames=$row_2['product_names'];
        $DiscountedProductsProductPrices=$row_2['product_prices'];
        $DiscountedProductsDiscountPercentages=$row_2['discount_percentages'];


        $DiscountedProductsIDArray=explode(",",$DiscountedProductsProductIDs);
        $DiscountedProductsNameArray=explode(",",$DiscountedProductsProductNames);
        $DiscountedProductPriceArray=explode(",",$DiscountedProductsProductPrices);
        $DiscountedProductDiscountPercentageArray=explode(",",$DiscountedProductsDiscountPercentages);


        $DiscountedPriceDiscountedPricesArray=array();

        //İndirimli Fiyatları Hesaplama
        for ($i = 0; $i < count($DiscountedProductsIDArray); $i++) {
          $DiscountedOriginalPrice = (float)$DiscountedProductPriceArray[$i];
          $DiscountedDiscountPercentage = (float)$DiscountedProductDiscountPercentageArray[$i]; 
          $DiscountedDiscountedPrice = $DiscountedOriginalPrice - ($DiscountedOriginalPrice * ($DiscountedDiscountPercentage / 100)); 
          array_push($DiscountedPriceDiscountedPricesArray, $DiscountedDiscountedPrice);
      }

        
    }


    //Yeni gelen ürünlerin çekilmesi
    $newly_arrived_products=$conn->query("SELECT GROUP_CONCAT(product_id) as product_ids, GROUP_CONCAT(product_name) as product_names, GROUP_CONCAT(price) as product_prices, GROUP_CONCAT(DiscountPercentage) as discount_percentages FROM (SELECT * FROM products WHERE DiscountPercentage != 0 LIMIT 3) as limited_products");

    if($row_3=$newly_arrived_products->fetch_assoc()){

        $NewlyArrivedProductIDs=$row_2['product_ids'];
        $NewlyArrivedProductNames=$row_2['product_names'];
        $NewlyArrivedProductPrices=$row_2['product_prices'];
        $NewlyArrivedDiscountPercentages=$row_2['discount_percentages'];


        $NewlyArrivedProductsIDArray=explode(",",$NewlyArrivedProductIDs);
        $NewlyArrivedProductsNameArray=explode(",",$NewlyArrivedProductNames);
        $NewlyArrivedProductPriceArray=explode(",",$NewlyArrivedProductPrices);
        $NewlyArrivedProductDiscountPercentageArray=explode(",",$NewlyArrivedDiscountPercentages);


        $NewlyArrivedDiscountedPricesArray=array();

        //İndirimli Fiyatları Hesaplama
        for ($i = 0; $i < count($NewlyArrivedProductsIDArray); $i++) {
          $NewlyArrivedOriginalPrice = (float)$NewlyArrivedProductPriceArray[$i];
          $NewlyArrivedDiscountPercentage = (float)$NewlyArrivedProductDiscountPercentageArray[$i];
          $NewlyArrivedDiscountedPrice = $NewlyArrivedOriginalPrice - ($NewlyArrivedOriginalPrice * ($NewlyArrivedDiscountPercentage / 100));
          
          // Push the discounted price into the array
          array_push($NewlyArrivedDiscountedPricesArray, $NewlyArrivedDiscountedPrice);
      }


    }
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel='stylesheet' type='text/css' media='screen' href='./style/landingpage.css?v=<?php echo time(); ?>'>
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

    <br><br>

    <div id="carousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="d-block w-100" src="medya/IphoneIndirim.png" alt="First slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="medya/samsunganasayfa.png" alt="Second slide">
          </div>
          <div class="carousel-item">
            <img class="d-block w-100" src="medya/samsunganasayfa2.jpg" alt="Third slide">
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>



      <br><br><br><br><br>

    <!--Markası Apple olan ürünleri çek ve göster-->
    <div id="apple-phone-container" class="container-fluid">
        <h1>Apple Telefonlar</h1>

        <br><br>

        <div id="product-container" class="container-fluid">
            <?php

              //Apple ürünlerinin listelenmesi
              for($i=0;$i<count($AppleProductIDArray);$i++){

                echo "<div class='container p-0 m-0 gap-5' id='ürün'><a href='display-product.php?product_id=$AppleProductIDArray[$i]' id='ürün-link'><div style='background-image: url(./TelefonFoto/$AppleProductIDArray[$i]-1.png);' id='foto' class='container-fullwidth'></div><br><p id='ürün-isim'>$AppleProductNameArray[$i]</p><p id='ürün-fiyat'>$AppleProductsDiscountedPricesArray[$i] TL</p></a></div>";
              }
            ?>
        </div>
    </div>


    <br><br><br><br><br><br>

    <!--İndirimli ürünlerin gösterilmesi(Eğer discount değeri 0 ise fiyatın üstünü çiz ve indirimli fiyatı göster)-->
    <div id="on-discount-container" class="container-fluid">

        <h1>İndirimde Olanlar</h1>

        <br><br>

        <div id="product-container" class="container-fluid">
            <?php
            //İndirimli ürünlerin listelenmesi

            for($i=0;$i<count($DiscountedProductsIDArray);$i++){

              echo "<div class='container p-0 m-0 gap-5' id='ürün'><a href='display-product.php?product_id=$DiscountedProductsIDArray[$i]' id='ürün-link'><div style='background-image: url(./TelefonFoto/$DiscountedProductsIDArray[$i]-1.png);' id='foto' class='container-fullwidth'></div><br><p id='ürün-isim'>$DiscountedProductsNameArray[$i]</p><p id='ürün-fiyat'>$DiscountedPriceDiscountedPricesArray[$i] TL</p></a></div>";
            }
            ?>
        </div>
    </div>  

    <br><br><br><br><br><br>

    <!--IsNewlyArrived değeri Yes olan ürünleri göster-->
    <div id="newly-arrived-container" class="container-fluid">

      <h1>Yeni Gelenler</h1>

      <br><br>

      <div id="product-container" class="container-fluid">
          <?php
            //Yeni Gelen ürünlerin listelenmesi


              
            $NewlyArrivedProductsIDArray=explode(",",$NewlyArrivedProductIDs);
            $NewlyArrivedProductsNameArray=explode(",",$NewlyArrivedProductNames);
            $NewlyArrivedProductPriceArray=explode(",",$NewlyArrivedProductPrices);
            $NewlyArrivedProductDiscountPercentageArray=explode(",",$NewlyArrivedDiscountPercentages);


            for($i=0;$i<count($NewlyArrivedProductsIDArray);$i++){

              echo "<div class='container p-0 m-0 gap-5' id='ürün'><a href='display-product.php?product_id={$NewlyArrivedProductsIDArray[$i]}' id='ürün-link'><div style='background-image: url(./TelefonFoto/$NewlyArrivedProductsIDArray[$i]-1.png);' id='foto' class='container-fullwidth'></div><br><p id='ürün-isim'>$NewlyArrivedProductsNameArray[$i]</p><p id='ürün-fiyat'>$NewlyArrivedDiscountedPricesArray[$i] TL</p></a></div>";
            }
          ?>
      </div>
    </div>

      <!--TODO:Footer-->

      <br><br><br><br><br><br>

      <footer class="bg-body-tertiary text-center text-lg-start">
      <!-- Copyright -->
      <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
        © 2020 Copyright:
        <a class="text-body" href="">Cihantoker.com</a>
      </div>
      <!-- Copyright -->
    </footer>

</body>
</html>
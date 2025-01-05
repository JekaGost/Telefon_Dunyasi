<?php

  session_start();

  //Session'ın alınması ve session'ın varlığına göre navbar'ın bastırılması
  $SessionValue=$_SESSION['email'] ?? ''; //Eğer session yoksa değişkeni boşluğa ayarla

  $ColorFormDisplay="none"; //Renk formunun görünürlüğü


  if($SessionValue==""){

    $ColorFormDisplay="none";
  }

  else{

    $ColorFormDisplay="block";
  }

  $ProductID=$_GET['product_id'];

  $ButtonDisplay="none"; //Butonun görünürlüğü

  $Sayfa="display-product.php?product_id=$ProductID"; //Sayfa değişkeni


  // Database bağlantısı
  $conn = new mysqli("localhost", "root", "", "phpprojesidatabase");

  if ($conn->connect_error) {
      echo "<script>alert('DB bağlanamadı!')</script>";
  }

  $ShoppingCartProductDiscountPercentagesArray = array();
  $ShoppingCartProductNamesArray = array();
  $ShoppingCartProductPricesArray = array();
  $ShoppingCartDiscountedPricesArray = array();
  $ShoppingCartIDArray=array();


  //Ürün verilerinin çekilmesi(Ürün adı,fiyatı,renkler ve stok)
  $product=$conn->query("SELECT product_name,price,Color1,Color2,Color3,Color1Stock,Color2Stock,Color3Stock,DiscountPercentage from products WHERE product_id=$ProductID");

  if($row=$product->fetch_assoc()){

    $Productname=$row['product_name'];
    $ProductPrice=$row['price'];
    $ProductColor1=$row['Color1'];
    $ProductColor2=$row['Color2'];
    $ProductColor3=$row['Color3'];
    $Color1Stock=$row['Color1Stock'];
    $Color2Stock=$row['Color2Stock'];
    $Color3Stock=$row['Color3Stock'];
    $DiscountPercentage=$row['DiscountPercentage'];
    

    //İndirimli fiyatı hesaplamak için değeri integere çevirme
    settype($DiscountPercentage,'integer');
    settype($ProductPrice,'integer');

    $ShoppingCartTotalPrice=0;


    //İndirimli fiyatı hesaplama(Fiyat*((100-İndirim)/100))
    $DiscountedPrice=$ProductPrice*((100-$DiscountPercentage)/100);


    //Stok kalmamış ürünleri sepete eklememek için stok değerlerini integer'a çevirme
    settype($Color1Stock,'integer');
    settype($Color2Stock,'integer');
    settype($Color3Stock,'integer');



  }

      //Sepet verilerinin çekilmesi

      //Eğer kullanıcı giriş yapmamışsa sepet verilerini çekme

      if($SessionValue!=""){

        $ShoppingCartFetcher=$conn->query("SELECT shopping_cart FROM users WHERE email_address='$SessionValue'");

        if($row_2=$ShoppingCartFetcher->fetch_assoc()){
    
          $ShoppingCartText=$row_2['shopping_cart'];
  

          if($ShoppingCartText!=""){

            $ButtonDisplay="block";

            //Alışveriş sepeti değerinin array içine alınması
            $ShoppingCartArray=explode("/",$ShoppingCartText);
      
            //Değerin başındaki parantezlerden kurtulması
            for($i=0;$i<count($ShoppingCartArray);$i++){
      
              $ShoppingCartArray[$i]=substr($ShoppingCartArray[$i],1,strlen($ShoppingCartArray[$i])-2);
            }
      
            //Değerin alt arraylere ayrılması
            $ShoppingCartArray_2=array();
      
            for($i=0;$i<count($ShoppingCartArray);$i++){
      
              array_push($ShoppingCartArray_2,explode(",",$ShoppingCartArray[$i]));
            }
      
      
      
            
            //Ürün verilerinin çekilmesi için Sepetteki ürünlerin ID'lerinin birleştirilmesi
      
            for($i=0;$i<count($ShoppingCartArray_2);$i++){
      
              array_push($ShoppingCartIDArray,$ShoppingCartArray_2[$i][0]);
            }
      
            $ShoppingCartProductIDText=join(",",$ShoppingCartIDArray);

            
             // Sepetteki ürünlerin verilerinin çekilmesi
            $ShoppingCartProductFetcher = $conn->query("SELECT product_name, price, DiscountPercentage FROM products WHERE product_id IN($ShoppingCartProductIDText)");

            if ($ShoppingCartProductFetcher && $ShoppingCartProductFetcher->num_rows > 0) {
              
                    while ($row = $ShoppingCartProductFetcher->fetch_row()) {
                        $ShoppingCartProductNamesArray[] = $row[0]; // product_name
                        $ShoppingCartProductPricesArray[] = (float)$row[1]; // price
                        $ShoppingCartProductDiscountPercentagesArray[] = (float)$row[2]; // DiscountPercentage
                    }

                    $ShoppingCartDiscountedPricesArray = [];
                    $ShoppingCartTotalPrice = 0;

                    // Ürünlerin indirimlerinin hesaplanması
                    for ($i = 0; $i < count($ShoppingCartIDArray); $i++) {
                        $originalPrice = $ShoppingCartProductPricesArray[$i];
                        $discountPercentage = $ShoppingCartProductDiscountPercentagesArray[$i];
                        $DiscountedPrice_2 = $originalPrice - ($originalPrice * ($discountPercentage / 100));
                        $ShoppingCartDiscountedPricesArray[] = $DiscountedPrice_2;

                        // Sepet toplam fiyatını güncelle
                        $ShoppingCartTotalPrice += $DiscountedPrice_2 * $ShoppingCartArray_2[$i][2]; // Miktarı hesaba kat
                    }
            }

            else{

              echo "Sepet ürünleri bulunamadı veya sorguda hata oluştu.";
            }
      
          }
  
        }
  
      }


      //Ürün tablosu için ürün verilerinin çekilmesi
      $ProductInfoFetcher=$conn->query("SELECT brand,operating_system,processor,ram,storage_capacity,screen_size,battery_capacity,camera_details,connectivity FROM products WHERE product_id=$ProductID");
    
      if($row_4=$ProductInfoFetcher->fetch_assoc()){
          
        $ProductBrand=$row_4['brand'];
        $ProductOS=$row_4['operating_system'];
        $ProductProcessor=$row_4['processor'];
        $ProductRam=$row_4['ram'];
        $ProductStorage=$row_4['storage_capacity'];
        $ProductScreen=$row_4['screen_size'];
        $ProductBattery=$row_4['battery_capacity'];
        $ProductCamera=$row_4['camera_details'];
        $ProductConnectivity=$row_4['connectivity'];
          
      }
    


      

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Ürün Göster</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel='stylesheet' type='text/css' media='screen' href='./style/display-product.css?v=<?php echo time(); ?>'>
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

              <?php
              
                if($SessionValue!=""){

                  echo "<a class='nav-link' href='ana-sayfa.php'>Ana Sayfa</a>";
                }
                else{

                  echo "<a class='nav-link' href='index.php'>Ana Sayfa</a>";
                }
              ?>

            </li>
            <li class="nav-item active">
                <?php
                  if($SessionValue!=""){
                    echo "<a class='nav-link' href='user-profile.php'>Profil</a>";
                  }

                  else{
                    echo "<a class='nav-link' href='login.php'>Giriş Yap</a>";
                  }
                ?>
            </li>
            <li class="nav-item active">
                  <?php 
                    if($SessionValue==""){
                      echo "<a class='nav-link' href='kayit-ol.php'>Kayıt Ol</a>";
                    }
                  ?>
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

        <?php
          if($SessionValue!=""){

            echo "<a class='nav-link'  id='log-off-button' href='index.php'>Çıkış Yap</a>";

            echo "<a id='shopping-cart-icon' class='nav-link' href='#'><i class='fa-solid fa-cart-shopping'></i></a>";
          }
        ?>
  </nav>


  <div id="shopping-cart-div" class="container w-50">
    <?php
      //Ürünlerin listelenmesi

      //Eğer session varsa sepeti göster

      if($SessionValue!=""){

        if($ShoppingCartText!=""){

          for($i=0;$i<count($ShoppingCartIDArray);$i++){

            $quantity=$ShoppingCartArray_2[$i][2];
            $Color=$ShoppingCartArray_2[$i][1];

            //Eğer üründe indirim varsa indirimli bastır yoksa normal bastır

            if($ShoppingCartProductDiscountPercentagesArray[$i]!="0"){

              //Renklere göre fotoğrafı değiştir
  
              if($Color=="Siyah"){
  
                //1.Fotoğrafı göster
                echo "<div id='product-div' class='container-fluid d-flex justify-content-start align-items-center flex-row'><div style='background-image:url(./TelefonFoto/" . $ShoppingCartIDArray[$i] . "-1.png)' id='photo-div' class='container'></div><div id='info-div' class='container d-flex justify-content-around flex-column gap-auto'><a style='text-decoration-color:black;' href='display-product.php?product_id=$ShoppingCartIDArray[$i]'><h1 id='product-name'>$ShoppingCartProductNamesArray[$i] ({$Color})</h1></a><div id='price-div' class='container-fluid d-flex justify-content-start align-items-center flex-row px-0'><p id='product-price'>$ShoppingCartProductPricesArray[$i] TL</p><p id='discounted-price'>$ShoppingCartDiscountedPricesArray[$i] TL</p></div><p id='product-quantity'>Adet:$quantity</p></div><div id='remove-product-div' class='container d-flex justify-content-center align-items-center'><a href='remove-product-from-shop-cart.php?index=$i&page=$Sayfa'>X</a></div></div>";
              }
  
              else if($Color=="Beyaz"){
  
                //2.Fotoğrafı Göster
                echo "<div id='product-div' class='container-fluid d-flex justify-content-start align-items-center flex-row'><div style='background-image:url(./TelefonFoto/" . $ShoppingCartIDArray[$i] . "-2.png)' id='photo-div' class='container'></div><div id='info-div' class='container d-flex justify-content-around flex-column gap-auto'><a style='text-decoration-color:black;' href='display-product.php?product_id=$ShoppingCartIDArray[$i]'><h1 id='product-name'>$ShoppingCartProductNamesArray[$i] ({$Color})</h1></a><div id='price-div' class='container-fluid d-flex justify-content-start align-items-center flex-row px-0'><p id='product-price'>$ShoppingCartProductPricesArray[$i] TL</p><p id='discounted-price'>$ShoppingCartDiscountedPricesArray[$i] TL</p></div><p id='product-quantity'>Adet:$quantity</p></div><div id='remove-product-div' class='container d-flex justify-content-center align-items-center'><a href='remove-product-from-shop-cart.php?index=$i&page=$Sayfa'>X</a></div></div>";
              }
  
              else{
                //3.Fotoğrafı Göster
                echo "<div id='product-div' class='container-fluid d-flex justify-content-start align-items-center flex-row'><div style='background-image:url(./TelefonFoto/" . $ShoppingCartIDArray[$i] . "-3.png)' id='photo-div' class='container'></div><div id='info-div' class='container d-flex justify-content-around flex-column gap-auto'><a style='text-decoration-color:black;' href='display-product.php?product_id=$ShoppingCartIDArray[$i]'><h1 id='product-name'>$ShoppingCartProductNamesArray[$i] ({$Color})</h1></a><div id='price-div' class='container-fluid d-flex justify-content-start align-items-center flex-row px-0'><p id='product-price'>$ShoppingCartProductPricesArray[$i] TL</p><p id='discounted-price'>$ShoppingCartDiscountedPricesArray[$i] TL</p></div><p id='product-quantity'>Adet:$quantity</p></div><div id='remove-product-div' class='container d-flex justify-content-center align-items-center'><a href='remove-product-from-shop-cart.php?index=$i&page=$Sayfa'>X</a></div></div>";
              }
            }
  
            else{
  
              if($Color=="Siyah"){
  
                echo "<div id='product-div' class='container-fluid d-flex justify-content-start align-items-center flex-row'><div style='background-image:url(./TelefonFoto/" . $ShoppingCartIDArray[$i] . "-1.png)' id='photo-div' class='container'></div><div id='info-div' class='container d-flex justify-content-around flex-column gap-auto'><a style='text-decoration-color:black;' href='display-product.php?product_id=$ShoppingCartIDArray[$i]'><h1 id='product-name'>$ShoppingCartProductNamesArray[$i] ({$Color})</h1></a><div id='price-div' class='container-fluid d-flex justify-content-start align-items-center flex-row px-0'><p style='text-decoration:none' id='product-price'>$ShoppingCartProductPricesArray[$i] TL</p><p style='display:none' id='discounted-price'>$ShoppingCartDiscountedPricesArray[$i] TL</p></div><p id='product-quantity'>Adet:$quantity</p></div><div id='remove-product-div' class='container d-flex justify-content-center align-items-center'><a href='remove-product-from-shop-cart.php?index=$i&page=ana-sayfa.php'>X</a></div></div>";
              }
  
              else if($Color=="Beyaz"){
  
                echo "<div id='product-div' class='container-fluid d-flex justify-content-start align-items-center flex-row'><div style='background-image:url(./TelefonFoto/" . $ShoppingCartIDArray[$i] . "-2.png)' id='photo-div' class='container'></div><div id='info-div' class='container d-flex justify-content-around flex-column gap-auto'><a style='text-decoration-color:black;' href='display-product.php?product_id=$ShoppingCartIDArray[$i]'><h1 id='product-name'>$ShoppingCartProductNamesArray[$i] ({$Color})</h1></a><div id='price-div' class='container-fluid d-flex justify-content-start align-items-center flex-row px-0'><p style='text-decoration:none' id='product-price'>$ShoppingCartProductPricesArray[$i] TL</p><p style='display:none' id='discounted-price'>$ShoppingCartDiscountedPricesArray[$i] TL</p></div><p id='product-quantity'>Adet:$quantity</p></div><div id='remove-product-div' class='container d-flex justify-content-center align-items-center'><a href='remove-product-from-shop-cart.php?index=$i&page=ana-sayfa.php'>X</a></div></div>";
              }
  
              else{
  
                echo "<div id='product-div' class='container-fluid d-flex justify-content-start align-items-center flex-row'><div style='background-image:url(./TelefonFoto/" . $ShoppingCartIDArray[$i] . "-3.png)' id='photo-div' class='container'></div><div id='info-div' class='container d-flex justify-content-around flex-column gap-auto'><a style='text-decoration-color:black;' href='display-product.php?product_id=$ShoppingCartIDArray[$i]'><h1 id='product-name'>$ShoppingCartProductNamesArray[$i] ({$Color})</h1></a><div id='price-div' class='container-fluid d-flex justify-content-start align-items-center flex-row px-0'><p style='text-decoration:none' id='product-price'>$ShoppingCartProductPricesArray[$i] TL</p><p style='display:none' id='discounted-price'>$ShoppingCartDiscountedPricesArray[$i] TL</p></div><p id='product-quantity'>Adet:$quantity</p></div><div id='remove-product-div' class='container d-flex justify-content-center align-items-center'><a href='remove-product-from-shop-cart.php?index=$i&page=ana-sayfa.php'>X</a></div></div>";
              }
  
      
            }

          }
        }

        else{

          echo "<div class='container-fluid d-flex justify-content-center align-items-center'><p>Alışveriş sepetiniz boş!</p></div>";
        }
      }

    ?>

    <div id="total-price-div" class="container-fluid d-flex justify-content-start align-items-center flex-row gap-2">
        <p id="text">Toplam:</p>
        <p id="price"><?php echo $ShoppingCartTotalPrice?> TL</p>
      </div>


      <div id="complete-order-div" class="container-fluid d-flex justify-content-start align-items-center">
              
        <form action="proceed-checkout.php" method="POST">
          <button style="display:<?php echo $ButtonDisplay?>;" class="btn btn-primary">Siparişi Tamamla</button>
        </form>
      </div>
  </div>

  

  <br/><br/>

  <div id="product-display-product-display-div" class="container-fluid d-flex justify-content-center flex-row">
    
    <div id="photos-div" class="container w-50">
      

      <div style="background-image: url(./TelefonFoto/<?php echo $ProductID?>-1.png);" id="photo-1" class="container w-100"></div>
    </div>

    <div id="info-div" class="container w-50 px-5">

      <h1 class="text-start px-5" id="product-name-text"><?php echo $Productname?></h1>

      <br>
      

      <?php
      
          //Eğer indirim değeri 0 ise sadece price-text'i bastor ve çizgiyi kaldırıp font boyutunu 3rem yap

          if($DiscountPercentage==0){

            echo "<p style='font-size: 3rem; text-decoration: none;' id='price-text' class='text-start px-5'>$ProductPrice TL</p>";
          }
          
          else{

            echo "<p id='price-text' class='text-start px-5'>$ProductPrice TL</p>";
            echo "<br>";
            echo "<p class='text-start px-5' id='discounted-price-text'>$DiscountedPrice TL</p>";
          }
          
      ?>

      <br><br>
      

      <form style="display:<?php echo $ColorFormDisplay?>" id="shopping-cart-product-add-form" action="adding-product-to-the-shopping-cart.php" method="GET">

      <input type="hidden" value="<?php echo $_GET['product_id']?>" name="id-input">

      <div id="colors-div" class="row d-flex px-5">
        <div class="col">
            <div class="form-check">
                <input value="<?php echo $ProductColor1?>" class="form-check-input" type="radio" name="color-input" id="color-input-1">
                <label class="form-check-label" for="color-input-1"><?php echo $ProductColor1?></label>
            </div>
        </div>
        <div class="col">
            <div class="form-check">
                <input value="<?php echo $ProductColor2?>"  class="form-check-input" type="radio" name="color-input" id="color-input-2">
                <label class="form-check-label" for="color-input-2"><?php echo $ProductColor2?></label>
            </div>
        </div>


        

          <?php

          //Eğer 3.renk varsa 3.rengi de bastır
          if($ProductColor3!=""){
          
          echo "<div class='col'>
            <div class='form-check'>
                <input value='$ProductColor3' class='form-check-input' type='radio' name='color-input' id='color-input-3'>
                <label class='form-check-label' for='color-input-3'>$ProductColor3</label>
            </div>
          </div>";

          }
          ?>
      </div>

      <br>
      <br>

      <div id="button-div" class="container"><button type="submit" class="btn btn-primary">Sepete Ekle</button></div>

      </form>


      <?php
      
          //Eğer session boş ise girişi hatırlat
          if($SessionValue==""){

            echo "<div class='container d-flex justify-content-start align-items-center'><p style='font-size:1.2rem' id='login-reminder'>Ürünü sepete eklemek için giriş yapmalısınız!</p></div>";
          }
      ?>


    </div>
  </div>

  <br><br><br><br><br><br><br><br>

  <div id="product-spec-div" class="container-fluid d-flex justfify-content-center align-items-center flex-column gap-0">

    <h1 id="header">Özellikler</h1>

    <br>

    <div id="spec-container" class="container-fluid d-flex justify-content-start align-items-start flex-column gap-auto">


          <div id="info" class="container w-25 pt-5 d-flex justify-content-center align-items-center">
            <h1>Marka:</h1>
            <h1 id="info-text"><?php echo $ProductBrand?></h1>
          </div>

          <div id="info" class="container w-25 pt-5 d-flex justify-content-center align-items-center">
            <h1>İşletim Sistemi:</h1>
            <h1 id="info-text"><?php echo $ProductOS?></h1>
          </div>

          <div id="info" class="container w-25 pt-5 d-flex justify-content-center align-items-center">
            <h1>İşlemci:</h1>
            <h1 id="info-text"><?php echo $ProductProcessor?></h1>
          </div>

          <div id="info" class="container w-25 pt-5 d-flex justify-content-center align-items-center">
            <h1>Ram:</h1>
            <h1 id="info-text"><?php echo $ProductRam?></h1>
          </div>

          <div id="info" class="container w-25 pt-5 d-flex justify-content-center align-items-center">
            <h1>Hafıza:</h1>
            <h1 id="info-text"><?php echo $ProductStorage?> </h1>
          </div>

          <div id="info" class="container w-25 pt-5 d-flex justify-content-center align-items-center">
            <h1>Ekran Boyutu:</h1>
            <h1 id="info-text"><?php echo $ProductScreen?> İnç</h1>
          </div>

          <div id="info" class="container w-25 pt-5 d-flex justify-content-center align-items-center">
            <h1>Batarya:</h1>
            <h1 id="info-text"><?php echo $ProductBattery?></h1>
          </div>

          <div id="info" class="container w-25 pt-5 d-flex justify-content-center align-items-center">
            <h1>Kamera:</h1>
            <h1 id="info-text"><?php echo $ProductCamera?></h1>
          </div>

          <div id="info" class="container w-25 pt-5 d-flex justify-content-center align-items-center">
            <h1>Bağlantı:</h1>
            <h1 id="info-text"><?php echo $ProductConnectivity?></h1>
          </div>
    </div>

    
  </div>
</body>
<script>
  
  document.addEventListener("DOMContentLoaded",function(){

    var ShoppingCartIcon=document.getElementById("shopping-cart-icon");
    var ShoppingCartDiv=document.getElementById("shopping-cart-div");
    var ShoppingcartStatus="closed";

    //Eğer kullanıcı alışveriş sepeti ikonuna tıklarsa alışveriş sepetinin görünürlüğünü değiştir
    ShoppingCartIcon.addEventListener("click",function(){
      
      //Alışveriş sepeti kapalıysa aç
      if(ShoppingcartStatus=="closed"){
        ShoppingCartDiv.style.display="flex";
        ShoppingcartStatus="open";
      }

      //Alışveriş sepeti açıksa kapat
      else{
        ShoppingCartDiv.style.display="none";
        ShoppingcartStatus="closed";
      }
    });


    //Renk değiştikçe ürün fotosuun değişmesi

    var Photo1=document.getElementById("photo-1");

    var Radio1=document.getElementById("color-input-1");
    var Radio2=document.getElementById("color-input-2");
    var Radio3=document.getElementById("color-input-3");

    //1.Radyo butonuna basılınca fotoğrafı 1.renk yap
    Radio1.addEventListener("change",function(){
    
      Photo1.style.backgroundImage="url(./TelefonFoto/<?php echo $ProductID?>-1.png)";
    });

    //2.Radyo butonuna tıklandığı zaman fotoğrafı 2.renk yap
    Radio2.addEventListener("change",function(){

      Photo1.style.backgroundImage="url(./TelefonFoto/<?php echo $ProductID?>-2.png)";
    });


    //3.Radyo butonuna tıklandığı zaman fotoğrafı 3.renk yap
    Radio3.addEventListener("change",function(){

      Photo1.style.backgroundImage="url(./TelefonFoto/<?php echo $ProductID?>-3.png)";
    });



  });
</script>
</html>

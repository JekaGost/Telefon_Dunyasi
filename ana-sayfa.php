<?php

    session_start();


    $Email=$_SESSION['email'];

    $Sayfa="ana-sayfa.php"; //Sepetten ürün silme işlemi için sayfa değişkeni

    // Database bağlantısı
    $conn = new mysqli("localhost", "root", "", "phpprojesidatabase");

    $ButtonDisplay="none";

    if ($conn->connect_error) {
        echo "<script>alert('DB bağlanamadı!')</script>";
    }

    //Ürünlerin tablodan çekilmesi
    $products=$conn->query("SELECT GROUP_CONCAT(product_id) as product_ids,GROUP_CONCAT(product_name) as product_names,GROUP_CONCAT(price) as prices,GROUP_CONCAT(DiscountPercentage) as discount_percentages from products");

    $ShoppingCartProductDiscountPercentagesArray = array();
    $ShoppingCartProductNamesArray = array();
    $ShoppingCartProductPricesArray = array();
    $ShoppingCartTotalPrice = 0;
    $ShoppingCartDiscountedPricesArray = array();

    if($row=$products->fetch_assoc()){

        $Productname=$row['product_names'];
        $ProductID=$row['product_ids'];
        $ProductPrice=$row['prices'];
        $DiscountPercentage=$row['discount_percentages'];

        $Productnamearray=explode(",",$Productname);
        $ProductPriceArray=explode(",",$ProductPrice);
        $ProductIDArray=explode(",",$ProductID);
        $DiscountPercentageArray=explode(",",$DiscountPercentage);
        


        $DiscountedPriceArray=array();

        //İndirimli Fiyatları Hesaplama
        
        for ($i = 0; $i < count($ProductIDArray); $i++) {
          $ProductOriginalPrice = (float)$ProductPriceArray[$i];
          $ProductDiscountPercentage = (float)$DiscountPercentageArray[$i]; 
          $ProductDiscountedPrice = $ProductOriginalPrice - ($ProductOriginalPrice * ($ProductDiscountPercentage / 100)); 
          array_push($DiscountedPriceArray, $ProductDiscountedPrice);
        }
    }



    //Sepet verilerinin çekilmesi
    $ShoppingCartFetcher=$conn->query("SELECT shopping_cart FROM users WHERE email_address='$Email'");

    if($row_2=$ShoppingCartFetcher->fetch_assoc()){

      $ShoppingCartText=$row_2['shopping_cart'];


      //Eğer alışveriş sepeti boşsa işlemleri yapma

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

        $ShoppingCartIDArray=array();

        for($i=0;$i<count($ShoppingCartArray_2);$i++){

          array_push($ShoppingCartIDArray,$ShoppingCartArray_2[$i][0]);
        }

        $ShoppingCartProductIDText=join(",",$ShoppingCartIDArray); //output: 1,2,3,2,1


        //Sepetteki ürünlerin verilerinin çekilmesi
        $ShoppingCartProductFetcher=$conn->query("SELECT GROUP_CONCAT(product_name) as product_names,GROUP_CONCAT(price) as prices,GROUP_CONCAT(DiscountPercentage) as discount_percentages from products WHERE product_id IN($ShoppingCartProductIDText)");


        if ($ShoppingCartProductFetcher && $ShoppingCartProductFetcher->num_rows > 0) {

            while ($row_2 = $ShoppingCartProductFetcher->fetch_row()) {

                $ShoppingCartProductNamesArray = explode(',', $row_2[0]);
                $ShoppingCartProductPricesArray = array_map('floatval', explode(',', $row_2[1])); 
                $ShoppingCartProductDiscountPercentagesArray = array_map('floatval', explode(',', $row_2[2])); 
            }
        
            $ShoppingCartDiscountedPricesArray = [];
            $ShoppingCartTotalPrice = 0;
        
            // Ürünlerin indirimlerinin hesaplanması
            for ($i = 0; $i < count($ShoppingCartIDArray); $i++) {
                $originalPrice = $ShoppingCartProductPricesArray[$i];
                $discountPercentage = $ShoppingCartProductDiscountPercentagesArray[$i];
                $DiscountedPrice = $originalPrice - ($originalPrice * ($discountPercentage / 100));
                $ShoppingCartDiscountedPricesArray[] = $DiscountedPrice;
        
                // Sepet toplam fiyatını güncelle
                $ShoppingCartTotalPrice += $DiscountedPrice * $ShoppingCartArray_2[$i][2]; // Miktarı hesaba kat
            }
        }
        
      }

    }
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Ana Sayfa</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/ana-sayfa.css?v=<?php echo time(); ?>">
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
              <a class="nav-link" href="ana-sayfa.php">Ana Sayfa</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="./user-profile.php">Profil</a>
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

        <a class='nav-link' id="log-off-button" href='index.php'>Çıkış Yap</a>

        <a id="shopping-cart-icon" class="nav-link" href="#"><i class="fa-solid fa-cart-shopping"></i></a>
    </nav>


    <div id="shopping-cart-div" class="container w-50 pt-3">

      <div id="products-div" class="container-fluid d-flex justify-content-start align-items-center flex-column gap-5">
        <?php


          //Eğer alışveriş sepetinde ürün varsa ürünleri bastır
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

            echo "<p>Alışveriş sepetiniz boş!</p>";
          }

        ?>
      </div>

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

    <br><br>

    <div id="discount-photos-div" class="container-fluid">
        <div id="photo-2" class="container-fluid">b</div>
        <div id="photo-3" class="container-fluid">c</div>
    </div>

    <br><br><br><br><br><br><br><br>

    <div id="product-container" class="container-fluid">
        <?php

        //Ürünlerin Listelenmesi
        
        for($i=0;$i<count($ProductIDArray);$i++){
          
          echo "<div class='container p-0 m-0 gap-5' id='ürün'><a href='display-product.php?product_id=$ProductIDArray[$i]' id='ürün-link'><div style='background-image: url(./TelefonFoto/$ProductIDArray[$i]-1.png);' id='foto' class='container-fullwidth'></div><br><p id='ürün-isim'>$Productnamearray[$i]</p><p id='ürün-fiyat'>$DiscountedPriceArray[$i] TL</p></a></div>";
        }
        ?>


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

<script>

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

  
</script>

</html>




<?php
    session_start();


    $Email=$_SESSION['email'];

    //Kullanıcı bilgileri(Eğer bunlardan bir tanesi boş ise sistem verileri database'den çekicek)
    $NameAnSurnameValue=$_SESSION['name_and_surname'] ?? '';
    $EmailInputSession=$_SESSION['email_input_session'] ?? '';
    $PhoneNumber=$_SESSION['phone_number'] ?? '';
    $City=$_SESSION['city'] ?? '';
    $PostalCode=$_SESSION['postal_code'] ?? '';
    $ShippingAddress=$_SESSION['shipping_address'] ?? '';
    $BillingAddress=$_SESSION['billing_address'] ?? '';

    //Ödeme Bilgileri
    $CardNumber=$_SESSION['card_number'] ?? '';
    $CardName=$_SESSION['card_name'] ?? '';
    $CVC=$_SESSION['CVC'] ?? '';


    

    // Database bağlantısı
    $conn = new mysqli("localhost", "root", "", "phpprojesidatabase");

    if ($conn->connect_error) {
        echo "<script>alert('DB bağlanamadı!')</script>";
    }


    //TODO:Alışveriş sepetinin çekilmesi
    $ShoppingCartFetcher=$conn->query("SELECT shopping_cart FROM users WHERE email_address='$Email'");

    if($shopping_cart_row=$ShoppingCartFetcher->fetch_assoc()){

        $ShoppingCartText=$shopping_cart_row['shopping_cart'];
    }

    
    //TODO:Sessionlarda veri boş ise database'den verileri çek


    //Ürünleri alt arraylere ayırma
    $ShoppingCartArray=explode("/",$ShoppingCartText);

    $ShoppingCartArray_2=array();
    $ShoppingCartArray_2_sub_array=array();

    for($i=0;$i<count($ShoppingCartArray);$i++){

        $ShoppingCartSubArrayText=substr($ShoppingCartArray[$i],1,strlen($ShoppingCartArray[$i])-2);

        $ShoppingCartArray_2_sub_array=explode(",",$ShoppingCartSubArrayText);

        array_push($ShoppingCartArray_2,$ShoppingCartArray_2_sub_array);
    }



    //Ürün ID'lerinin array içine alınması
    $ShoppingCartIDArray=array();

    for($i=0;$i<count($ShoppingCartArray_2);$i++){

        array_push($ShoppingCartIDArray,$ShoppingCartArray_2[$i][0]);
    }

    $ShoppingCartIDArrayText=join(",",$ShoppingCartIDArray);


    //Ürün verilerinin çekilmesi
    $ProductInfoFetcher=$conn->query("SELECT GROUP_CONCAT(product_name) as product_names,GROUP_CONCAT(price) as prices, GROUP_CONCAT(CAST(price - (price * DiscountPercentage / 100) AS INT)) AS discounted_prices FROM `products` WHERE product_id IN($ShoppingCartIDArrayText)");

    if($row_2=$ProductInfoFetcher->fetch_assoc()){

        $ProductName=$row_2['product_names'];
        $Prices=$row_2['prices'];
        $DiscountedPrices=$row_2['discounted_prices'];

    
        $ProductNameArray=explode(",",$ProductName);
        $PricesArray=explode(",",$Prices);
        $DiscountedPricesArray=explode(",",$DiscountedPrices);
    }


    //Eğer isim session'ı boş ise database'den veri çek
    if($NameAnSurnameValue==""){

        $NameFetcher=$conn->query("SELECT CONCAT(first_name,' ',last_name) AS NameValue FROM users WHERE email_address='$Email'");

        if($NameRow=$NameFetcher->fetch_assoc()){

            $_SESSION['name_and_surname']=$NameRow['NameValue'];
        }
    }


    //Eğer email session'ı boş ise email'i normal bırak
    if($EmailInputSession==""){

        $_SESSION['email_input_session']=$Email;
    }


    //Eğer telefon session'ı boş ise telefon numarasını database'den çek
    if($PhoneNumber==""){

        $PhoneFetcher=$conn->query("SELECT phone_number FROM users WHERE email_address='$Email'");

        if($PhoneRow=$PhoneFetcher->fetch_assoc()){

            $_SESSION['phone_number']=$PhoneRow['phone_number'];
        }
    }


    //Şehir
    if($City==""){

        $CityFetcher=$conn->query("SELECT City FROM users WHERE email_address='$Email'");

        if($CityRow=$CityFetcher->fetch_assoc()){

            $_SESSION['city']=$CityRow['City'];
        }
    }


    //Posta Kodu
    if($PostalCode==""){

        $PostalCodeFetcher=$conn->query("SELECT postal_code FROM users WHERE email_address='$Email'");

        if($PostCode=$PostalCodeFetcher->fetch_assoc()){

            $_SESSION['postal_code']=$PostCode['postal_code'];
        }
    }


    //Adres
    if($ShippingAddress==""){

        $ShippingAddressFetcher=$conn->query("SELECT shipping_address FROM users WHERE email_address='$Email'");

        
        if($ShippingAddress=$ShippingAddressFetcher->fetch_assoc()){

            $_SESSION['shipping_address']=$ShippingAddress['shipping_address'];
        }
    }


    //Fatura Adresi
    if($BillingAddress==""){

        $BillingAddressFetcher=$conn->query("SELECT billing_address FROM users WHERE email_address='$Email'");

        
        if($BillingAddress=$BillingAddressFetcher->fetch_assoc()){

            $_SESSION['billing_address']=$BillingAddress['billing_address'];
        }
    }


    //Kart numarası
    if($CardNumber==""){

        $CardNumberFetcher=$conn->query("SELECT CardNumber FROM users WHERE email_address='$Email'");

        if($CardNumberRow=$CardNumberFetcher->fetch_assoc()){

            $_SESSION['card_number']=$CardNumberRow['CardNumber'];
        }
    }

    //Kart isim
    if($CardName==""){

        $CardNameFetcher=$conn->query("SELECT CardName FROM users WHERE email_address='$Email'");

        if($CardNameRow=$CardNameFetcher->fetch_assoc()){

            $_SESSION['card_name']=$CardNameRow['CardName'];
        }
    }

    //CVC
    if($CVC==""){

        $CVCFetcher=$conn->query("SELECT CVC FROM users WHERE email_address='$Email'");

        if($CVCRow=$CVCFetcher->fetch_assoc()){

            $_SESSION['CVC']=$CVCRow['CVC'];
        }
    }


    //Fiyat Hesaplama

    $TotalPrice=0;

    for($i=0;$i<count($ShoppingCartArray_2);$i++){

        //Eğer ürün indirimdeyse indirimli fiyattan hesapla

        $ProductQuantity=(float)$ShoppingCartArray_2[$i][2];
        $ProductPrice=$DiscountedPricesArray[$i];

        $TotalPrice += $ProductQuantity * $ProductPrice;

    }

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Siparişi Tamamla</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel='stylesheet' type='text/css' media='screen'  href="style/proceed-checkout.css?v=<?php echo time(); ?>">
    <script src='main.js'></script>
</head>
<body>

    <div id="header-div" class="container-fluid pt-5 d-flex justify-content-start align-items-center">
        <h1 class="">Siparişi Onayla</h1>
    </div>

    <br><br><br><br>

    <div id="products-div" class="container-fluid d-flex justify-content-start align-items-center flex-column ">
        <?php
            //Ürünlerin listelenmesi

            for($i=0;$i<count($ShoppingCartArray_2);$i++){

                $ProductID=$ShoppingCartArray_2[$i][0];
                $ProductColor=$ShoppingCartArray_2[$i][1];
                $Quantity=$ShoppingCartArray_2[$i][2];

                //Eğer indirim varsa indirim yazısı olanı bastır;Yoksa normal bastır

                if($PricesArray[$i]==$DiscountedPricesArray){
                    
                    //İndirimsiz

                    //Ürünün rengine göre resminin belirlenmesi
                    if($ProductColor=="Siyah"){

                        //1.Fotoyu Göster
                        echo "<div id='product' class='container w-75 d-flex justify-content-center align-items-center'><div style='background-image:url(./TelefonFoto/" . $ProductID . "-1.png)' id='photo-div' class='container w-25'></div><div id='info-div' class='container'><a id='product-name' href='display-product.php?product_id=$ProductID'>$ProductNameArray[$i]($ProductColor)</a><br><br><div id='product-price-div' class='container-fluid px-0 d-flex justify-content-start align-items-center flex-row'><p style='text-decoration:none' id='product-price'>1000 TL</p><p style='display:none' id='discounted-price'>900 TL</p></div><br><div id='product-quantity-div' class='container-fluid px-0'><p>Adet:$Quantity</p></div></div><div id='remove-product-div' class='container d-flex justify-content-center align-items-center'><a href='remove-product-from-shop-cart.php?index=$i&page=proceed-checkout.php'>X</a></div></div>";
                    }

                    else if($ProductColor=="Beyaz"){

                        echo "<div id='product' class='container w-75 d-flex justify-content-center align-items-center'><div style='background-image:url(./TelefonFoto/" . $ProductID . "-2.png)' id='photo-div' class='container w-25'></div><div id='info-div' class='container'><a id='product-name' href='display-product.php?product_id=$ProductID'>$ProductNameArray[$i]($ProductColor)</a><br><br><div id='product-price-div' class='container-fluid px-0 d-flex justify-content-start align-items-center flex-row'><p style='text-decoration:none' id='product-price'>1000 TL</p><p style='display:none' id='discounted-price'>900 TL</p></div><br><div id='product-quantity-div' class='container-fluid px-0'><p>Adet:$Quantity</p></div></div><div id='remove-product-div' class='container d-flex justify-content-center align-items-center'><a href='remove-product-from-shop-cart.php?index=$i&page=proceed-checkout.php'>X</a></div></div>";
                    }

                    else{

                        echo "<div id='product' class='container w-75 d-flex justify-content-center align-items-center'><div style='background-image:url(./TelefonFoto/" . $ProductID . "-3.png)' id='photo-div' class='container w-25'></div><div id='info-div' class='container'><a id='product-name' href='display-product.php?product_id=$ProductID'>$ProductNameArray[$i]($ProductColor)</a><br><br><div id='product-price-div' class='container-fluid px-0 d-flex justify-content-start align-items-center flex-row'><p style='text-decoration:none' id='product-price'>1000 TL</p><p style='display:none' id='discounted-price'>900 TL</p></div><br><div id='product-quantity-div' class='container-fluid px-0'><p>Adet:$Quantity</p></div></div><div id='remove-product-div' class='container d-flex justify-content-center align-items-center'><a href='remove-product-from-shop-cart.php?index=$i&page=proceed-checkout.php'>X</a></div></div>";
                    }
                }

                else{

                    //İndirimli
                    if($ProductColor=="Siyah"){

                        echo "<div id='product' class='container w-75 d-flex justify-content-center align-items-center'><div style='background-image:url(./TelefonFoto/" . $ProductID . "-1.png)' id='photo-div' class='container w-25'></div><div id='info-div' class='container'><a id='product-name' href='display-product.php?product_id=$ProductID'>$ProductNameArray[$i]($ProductColor)</a><br><br><div id='product-price-div' class='container-fluid px-0 d-flex justify-content-start align-items-center flex-row'><p id='product-price'>$PricesArray[$i] TL</p><p id='discounted-price'> $DiscountedPricesArray[$i] TL</p></div><br><div id='product-quantity-div' class='container-fluid px-0'><p>Adet:$Quantity</p></div></div><div id='remove-product-div' class='container d-flex justify-content-center align-items-center'><a href='remove-product-from-shop-cart.php?index=$i&page=proceed-checkout.php'>X</a></div></div>";
                    }
                    
                    else if($ProductColor=="Beyaz"){

                        echo "<div id='product' class='container w-75 d-flex justify-content-center align-items-center'><div style='background-image:url(./TelefonFoto/" . $ProductID . "-2.png)' id='photo-div' class='container w-25'></div><div id='info-div' class='container'><a id='product-name' href='display-product.php?product_id=$ProductID'>$ProductNameArray[$i]($ProductColor)</a><br><br><div id='product-price-div' class='container-fluid px-0 d-flex justify-content-start align-items-center flex-row'><p id='product-price'>$PricesArray[$i] TL</p><p id='discounted-price'> $DiscountedPricesArray[$i] TL</p></div><br><div id='product-quantity-div' class='container-fluid px-0'><p>Adet:$Quantity</p></div></div><div id='remove-product-div' class='container d-flex justify-content-center align-items-center'><a href='remove-product-from-shop-cart.php?index=$i&page=proceed-checkout.php'>X</a></div></div>";
                    }

                    else{

                        echo "<div id='product' class='container w-75 d-flex justify-content-center align-items-center'><div style='background-image:url(./TelefonFoto/" . $ProductID . "-3.png)' id='photo-div' class='container w-25'></div><div id='info-div' class='container'><a id='product-name' href='display-product.php?product_id=$ProductID'>$ProductNameArray[$i]($ProductColor)</a><br><br><div id='product-price-div' class='container-fluid px-0 d-flex justify-content-start align-items-center flex-row'><p id='product-price'>$PricesArray[$i] TL</p><p id='discounted-price'> $DiscountedPricesArray[$i] TL</p></div><br><div id='product-quantity-div' class='container-fluid px-0'><p>Adet:$Quantity</p></div></div><div id='remove-product-div' class='container d-flex justify-content-center align-items-center'><a href='remove-product-from-shop-cart.php?index=$i&page=proceed-checkout.php'>X</a></div></div>";
                    }
                }


                
            }
        ?>
    </div>


    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>


    <div id="header-div" class="container-fluid pt-5 d-flex justify-content-start align-items-center">
        <h1 class="">Adres Ve Kullanıcı Bilgileri</h1>
    </div>

    <br><br>

    <div id="address-div" class="container-fluid pt-2 d-flex justify-content-center align-items-center flex-row flex-wrap">

        <div id="info-cell" class="container d-flex justify-content-center align-items-center flex-wrap">
            <p>İsim Soyisim: <?php echo $_SESSION['name_and_surname']?></p>
        </div>

        <div id="info-cell" class="container d-flex justify-content-center align-items-center flex-wrap">
            <p>Email: <?php echo $_SESSION['email_input_session']?></p>
        </div>
        
        <div id="info-cell" class="container d-flex justify-content-center align-items-center flex-wrap">
            <p>Telefon Numarası: <?php echo  $_SESSION['phone_number']?></p>
        </div>

        <div id="info-cell" class="container d-flex justify-content-center align-items-center flex-wrap">
            <p>Şehir: <?php echo $_SESSION['city']?></p>
        </div>  

        <div id="info-cell" class="container d-flex justify-content-center align-items-center flex-wrap">
            <p>Posta Kodu: <?php echo $_SESSION['postal_code'] ?></p>
        </div>  

        <div id="info-cell" class="container d-flex justify-content-center align-items-center flex-wrap">
            <p>Adres: <?php echo $_SESSION['shipping_address']?></p>
        </div>  
        
        <div id="info-cell" class="container d-flex justify-content-center align-items-center flex-wrap">
            <p>Fatura Adresi: <?php echo $_SESSION['billing_address'] ?></p>
        </div>  
    </div>


    <br><br>

    <div id="change-info-div" class="container-fluid pt-5 px-5">

        <form action="change-address-for-this-order.php" method="POST">

            <input type="hidden" name="name_and_surname_input" value="<?php echo $_SESSION['name_and_surname']?>">
            <input type="hidden" name="city_input" value="<?php echo $_SESSION['city']?>">
            <input type="hidden" name="postal_code_input" value="<?php echo $_SESSION['postal_code']?>">
            <input type="hidden" name="shipping_address_input" value="<?php echo $_SESSION['shipping_address']?>">
            <input type="hidden" name="billing_address_input" value="<?php echo  $_SESSION['billing_address']?>">
            <input type="hidden" name="email_input" value="<?php echo $_SESSION['email_input_session']?>">
            <input type="hidden" name="phone_input" value="<?php echo $_SESSION['phone_number']?>">

            <button type="submit">Adres Bilgilerini Bu Sipariş İçin Değiştir</button>
        </form>
    </div>


    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

    <div id="header-div" class="container-fluid pt-5 d-flex justify-content-start align-items-center">
        <h1 class="">Ödeme Bilgileri</h1>
    </div>

    <br><br>

    <div id="financial-div" class="container-fluid pt-2 d-flex justify-content-center align-items-center flex-row flex-wrap">


        <div id="info-cell" class="container d-flex justify-content-center align-items-center flex-wrap">
            <p>Kart Numarası: <?php echo $_SESSION['card_number']?></p>
        </div>

        <div id="info-cell" class="container d-flex justify-content-center align-items-center flex-wrap">
            <p>Kart Sahibi: <?php echo $_SESSION['card_name'] ?></p>
        </div>

        <div id="info-cell" class="container d-flex justify-content-center align-items-center flex-wrap">
            <p>CVC: <?php echo $_SESSION['CVC'] ?></p>
        </div>


        <br><br>

        <div id="change-info-div" class="container-fluid pt-5 px-5">

            <form action="change-payment-for-this-order.php" method="POST">

                <input type="hidden" name="card_name_input" value="<?php echo $_SESSION['card_name']?>">
                <input type="hidden" name="card_number_input" value="<?php echo $_SESSION['card_number']?>">
                <input type="hidden" name="cvc_input" value="<?php echo $_SESSION['CVC']?>">

                <button type="submit">Ödeme Bilgilerini Bu Sipariş İçin Değiştir</button>


            </form>
        </div>

        
    </div>

    <br><br><br><br><br>

    <div id="checkout-info-div" class="container-fluid d-flex justify-content-between align-items-center">
        <p id="total-price">Toplam Fiyat:<?php echo $TotalPrice?> TL<br><br> <?php echo count($ShoppingCartArray_2)?>   Ürün</p>

        <form method="POST">
            <button name="add-order-button" class="btn btn-primary">Siparişi Tamamla</button>
        </form>
    </div>
</body>
</html>


<?php

    //Sipraişin Eklenmesi
    if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['add-order-button'])){

        $ShoppingCartInsertArray=array();

        //Ürünlerin String Haline Getirilmesi
        for($i=0;$i<count($ShoppingCartArray_2);$i++){

            //Arrayin elemanlarını joinle
            $ProductText="[".join(",",$ShoppingCartArray_2[$i])."]";

            //ProductText'i ShoppingCartInsertArray içine koy
            array_push($ShoppingCartInsertArray,$ProductText);
        }

        $ShoppingCartInsertString=join("/",$ShoppingCartInsertArray);

        //Günün Tarihinin Alınması
        $currentDateTime = date("Y-m-d H:i:s");

        //Ürünler yazısını oluşturlması
        $OrderInserter = $conn->query("INSERT INTO `orders`(`UserID`, `Products`, `NameAndSurname`, `Email`, `PhoneNumber`, `ShippingAddress`, `BillingAddress`, `City`, `State`, `PostalCode`, `Cardname`, `Cardnumber`, `CVC`, `TotalPrice`, `OrderStatus`, `OrderDate`)
        VALUES (
            (SELECT users.user_id FROM users WHERE users.email_address='{$_SESSION['email_input_session']}'),
            '$ShoppingCartInsertString',
            '{$_SESSION['name_and_surname']}',
            '{$_SESSION['email_input_session']}',
            '{$_SESSION['phone_number']}',
            '{$_SESSION['shipping_address']}',
            '{$_SESSION['billing_address']}',
            '{$_SESSION['city']}',
            'TR',
            '{$_SESSION['postal_code']}',
            '{$_SESSION['card_name']}',
            '{$_SESSION['card_number']}',
            '{$_SESSION['CVC']}',
            '$TotalPrice',
            'Hazırlanıyor',
            '$currentDateTime'
        )");

        if ($OrderInserter) {

            echo "<script>alert('Satış Gerçekleşti')</script>";


            // Email session'ı hariç bütün sessionları yok et
            $emailValue = $_SESSION['email'];
            session_unset();
            $_SESSION['email'] = $emailValue;

            //Kullanıcının alışveriş sepetini boşalt
            $ShoppingCartUpdater = $conn->query("UPDATE users SET shopping_cart='' WHERE email_address='{$_SESSION['email']}'");

            if(!$ShoppingCartUpdater){

                "<script>alert('Sepet Boşaltılırken bir hata oluştu: ')</script>";           
            }

            //Kullanıcıyı ana sayfaya yönlendir

            echo "<script>window.location.href='ana-sayfa.php'</script>";


        } else {
            echo "<script>alert('Satış Gerçekleşirken bir hata oluştu: . $conn->error .')</script>";
        }



    }

?>


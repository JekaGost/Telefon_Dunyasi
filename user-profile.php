<?php

  session_start();

  // Database bağlantısı
  $conn = new mysqli("localhost", "root", "", "phpprojesidatabase");

  if ($conn->connect_error) {
       echo "<script>alert('DB bağlanamadı!')</script>";
  }


  $Email=$_SESSION['email'];

  //Kullanıcı verilerini session ile çekme
  $user=$conn->query("SELECT * FROM users WHERE email_address='$Email'");

  if($row=$user->fetch_assoc()){

    $UserID=$row['user_id'];
    $UserName=$row['first_name'];
    $UserSurname=$row['last_name'];
    $UserEmail=$row['email_address'];
    $UserPassword=$row['password_value'];
    $UserPhoneNumber=$row['phone_number'];
    $UserCardNumber=$row['Cardnumber'];
    $UserCardCVC=$row['CVC'];
    $UserCardName=$row['Cardname'];
    $UserDOB=$row['date_of_birth'];
    $UserShippingAddress=$row['shipping_address'];
    $UserCity=$row['city'];
    $UserbillingAddress=$row['billing_address'];
    $UserPostalCode=$row['postal_code'];
  }


  //Siparişlerin çekilmesi
  $OrdersFetcher=$conn->query("SELECT GROUP_CONCAT(OrderID) as order_ids,GROUP_CONCAT(TotalPrice) as total_prices,GROUP_CONCAT(Products,'>') as products,GROUP_CONCAT(OrderDate) as order_dates,GROUP_CONCAT(OrderStatus) as order_statuses FROM orders WHERE UserID=(SELECT users.user_id FROM users WHERE users.email_address='$Email')");

  if($row_2=$OrdersFetcher->fetch_assoc()){

    $OrderIDValue=$row_2['order_ids'];
    $TotalPrices=$row_2['total_prices'];
    $Products=$row_2['products'];
    $OrderDates=$row_2['order_dates'];
    $OrderStatus=$row_2['order_statuses'];

    $OrderIDArray=explode(",",$OrderIDValue);
    $TotalPriceArray=explode(",",$TotalPrices);
    $ProductsArray=explode(">",$Products);
    $OrderDateArray=explode(",",$OrderDates);
    $OrderStatusArray=explode(",",$OrderStatus);

    //Ürün sayısının hesaplanması(ProductsArray'deki ürünleri split et
    $OrderCountArray=array();

    for($i=0;$i<count($OrderIDArray);$i++){

      $a=explode("/",$ProductsArray[$i]);

      array_push($OrderCountArray,count($a));
    }



    //Sipariş durumu renklerinin oluşturulması

    /**
     * Kargoya verildi yeişl
     * Hazırlanıyor mavi
     * İptal Edildi Kırmızı
     */
    $OrderStatusColorArray=array();

    for($i=0;$i<count($OrderStatusArray);$i++){

      if($OrderStatusArray[$i]=="Kargoya Verildi"){

        array_push($OrderStatusColorArray,"green");
      }

      else if($OrderStatusArray[$i]=="Hazırlanıyor"){

        array_push($OrderStatusColorArray,"blue");
      }
      else{

        array_push($OrderStatusColorArray,"red");
      }

    }
  }


  //TODO:Önceki siparişlerin çekilmesi
  $PreviousOrdersFetcher=$conn->query("SELECT GROUP_CONCAT(PreviousOrdersID) as pre_order_ids,GROUP_CONCAT(TotalPrice) as total_prices,GROUP_CONCAT(Products,'>') as products,GROUP_CONCAT(OrderDate) as order_dates FROM previousorders WHERE UserID=(SELECT users.user_id FROM users WHERE users.email_address='$Email')");

  if($row_3=$PreviousOrdersFetcher->fetch_assoc()){

    $PreviousOrderIDValue=$row_3['pre_order_ids'];
    $PreviousTotalPrices=$row_3['total_prices'];
    $PreviousProducts=$row_3['products'];
    $PreviousOrderDates=$row_3['order_dates'];

    $PreviousOrderIDArray=explode(",",$PreviousOrderIDValue);
    $PreviousTotalPriceArray=explode(",",$PreviousTotalPrices);
    $PreviousProductsArray=explode(">",$PreviousProducts);
    $PreviousOrderDateArray=explode(",",$PreviousOrderDates);


    //Ürün sayısının hesaplanması(ProductsArray'deki ürünleri split et
    $PreviousOrderCountArray=array();

    for($i=0;$i<count($PreviousOrderIDArray);$i++){

      $a=explode("/",$PreviousProductsArray[$i]);

      array_push($PreviousOrderCountArray,count($a));
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel='stylesheet' type='text/css' media='screen' href="style/user-profile.css?v=<?php echo time(); ?>">
    <script src='main.js'></script>
</head>
<body>

    <div id="header-div" class="container-fluid">
      <h1 id="header">Kullanıcı Bilgileri</h1>
      <br><br>
    </div>


    <div id="forms-container" class="row d-flex justify-content-center">
        
      <div id="user-id-div" class="container w-50">
        <h1 class="text-center">Kullanıcı ID:<?php echo $UserID;?></h1>
      </div>


      <div id="forms-div" class="container w-50">

        <form action="change-user-info.php" method="POST">
          <div class="form-group">
            <label for="name-input">İsim</label>  
            <input type="text" name="input-value" value='<?php echo $UserName?>' id="name-input" class="form-control">
            
            <input type="hidden" name="ID-input" value=<?php echo $UserID?>/>
            <input type="hidden" name="column-name" value="first_name"/>
          </div>

          <div id="button-div" class="container">
            <button type="submit" class="btn btn-primary">İsmi Değiştir</button>
          </div>
        </form>

      </div>


      <div id="forms-div" class="container w-50">
        <form action="change-user-info.php" method="POST">
          <div class="form-group">
            <label for="surname-input">Soyisim</label>  
            <input type="text" name="surname-input" value='<?php echo $UserSurname?>' id="surname-input" class="form-control">
          </div>

          <div id="button-div" class="container">
            <button class="btn btn-primary">Soyisim Değiştir</button>
          </div>
        </form>
      </div>
      

      <div id="forms-div" class="container w-50">

        <form action="change-user-info.php" method="POST">
          <div class="form-group">
            <label for="email-input">Email</label>  

            <input type="email" name="input-value" value='<?php echo $UserEmail?>' id="email-input" class="form-control">

            <input type="hidden" name="ID-input" value=<?php echo $UserID?>/>
            <input type="hidden" name="column-name" value="email_address"/>

          </div>

          <div id="button-div" class="container">
            <button type="submit" class="btn btn-primary">Email Değiştir</button>
          </div>
        </form>
      </div>



      
      <div id="forms-div" class="container w-50">
        <form action="change-user-info.php" method="POST">
          <div class="form-group">
            <label for="phone-input">Telefon</label>  
            <input type="tel" name="input-value" value='<?php echo $UserPhoneNumber?>' id="phone-input" class="form-control">

            <input type="hidden" name="ID-input" value=<?php echo $UserID?>/>
            <input type="hidden" name="column-name" value="phone_number"/>
          </div>

          <div id="button-div" class="container">
            <button class="btn btn-primary">Telefon Değiştir</button>
          </div>
        </form>
      </div>


      
      <div id="forms-div" class="container w-50">
        <form action="change-user-info.php" method="POST">
          <div class="form-group">
            <label for="password-input">Şifre</label>  
            <input type="password" name="input-value" value='<?php echo $UserPassword?>' id="password-input" class="form-control">

            <input type="hidden" name="ID-input" value=<?php echo $UserID?>/>
            <input type="hidden" name="column-name" value="password_value"/>
          </div>

          <div id="button-div" class="container">
            <button class="btn btn-primary">Şifre Değiştir</button>
          </div>
        </form>
      </div>


      <div id="forms-div" class="container w-50">
        <form action="change-user-info.php" method="POST">
          <div class="form-group">
            <label for="dob-input">Doğum Tarihi</label>  
            <input type="date" name="input-value" value='<?php echo $UserDOB?>' id="dob-input" class="form-control">

            <input type="hidden" name="ID-input" value=<?php echo $UserID?>/>
            <input type="hidden" name="column-name" value="date_of_birth"/>
          </div>

          <div id="button-div" class="container">
            <button class="btn btn-primary">Doğum Tarihi Değiştir</button>
          </div>
        </form>
      </div>


      <div id="forms-div" class="container w-50">
        <form action="change-user-info.php" method="POST">
          <div class="form-group">
            <label for="card-number-input">Kart Numarası</label>  
            <input type="text" pattern="[0-9]{16}" name="input-value" value='<?php echo $UserCardNumber?>' id="card-number-input" class="form-control">

            <input type="hidden" name="ID-input" value=<?php echo $UserID?>/>
            <input type="hidden" name="column-name" value="Cardnumber"/>
          </div>

          <div id="button-div" class="container">
            <button class="btn btn-primary">Kart Num. Değiştir</button>
          </div>
        </form>
      </div>


      <div id="forms-div" class="container w-50">
        <form action="change-user-info.php" method="POST">
          <div class="form-group">
            <label for="card-name-input">Kart İsim</label>  
            <input type="text" name="input-value" value='<?php echo $UserCardName?>' id="card-name-input" class="form-control">

            <input type="hidden" name="ID-input" value=<?php echo $UserID?>/>
            <input type="hidden" name="column-name" value="Cardname"/>
          </div>

          <div id="button-div" class="container">
            <button class="btn btn-primary">Kart İsim Değiştir</button>
          </div>
        </form>
      </div>



      <div id="forms-div" class="container w-50">
        <form action="change-user-info.php" method="POST">
          <div class="form-group">
            <label for="card-name-input">CVC</label>  
            <input type="text" pattern="[0-9]{3}" id="input-value" value="<?php echo $UserCardCVC?>" name="input-value" class="form-control">

            <input type="hidden" name="ID-input" value=<?php echo $UserID?>/>
            <input type="hidden" name="column-name" value="CVC"/>
          </div>

          <div id="button-div" class="container">
            <button type="submit" class="btn btn-primary">CVC Değiştir</button>
          </div>
        </form>
      </div>
    </div>


    <br><br><br><br><br><br><br><br>

    <div id="header-div" class="container-fluid">
      <h1 id="header">Adres Bilgileri</h1>
      <br><br>
    </div>



    <div id="forms-container" class="row d-flex justify-content-center">


      <div id="forms-div" class="container w-50">
          <form action="change-user-info.php" method="POST">
            <div class="form-group">
              <label for="shipping-address-input">Adres </label>  
              <textarea type="text" name="input-value" id="card-name-input" class="form-control"><?php echo $UserShippingAddress?></textarea>

              <input type="hidden" name="ID-input" value=<?php echo $UserID?>/>
              <input type="hidden" name="column-name" value="shipping_address"/>
            </div>

            <div id="button-div" class="container">
              <button class="btn btn-primary">Adres Değiştir</button>
            </div>
          </form>
      </div>


      
      <div id="forms-div" class="container w-50">
          <form action="change-user-info.php" method="POST">
            <div class="form-group">
              <label for="shipping-address-input">Fatura Adresi</label>  
              <textarea type="text" name="input-value" id="card-name-input" class="form-control"><?php echo $UserbillingAddress?></textarea>

              <input type="hidden" name="ID-input" value=<?php echo $UserID?>/>
              <input type="hidden" name="column-name" value="billing_address"/>
            </div>

            <div id="button-div" class="container">
              <button class="btn btn-primary">Fatura Adresi Değiştir</button>
            </div>
          </form>
      </div>


            
      <div id="forms-div" class="container w-50">
          <form action="change-user-info.php" method="POST">
            <div class="form-group">
              <label for="city-input">Şehir</label>  
              <input type="text" name="input-value" value="<?php echo $UserCity ?>" id="city-input" class="form-control"/>

              <input type="hidden" name="ID-input" value=<?php echo $UserID?>/>
              <input type="hidden" name="column-name" value="city"/>
            </div>

            <div id="button-div" class="container">
              <button class="btn btn-primary">Şehir Değiştir</button>
            </div>
          </form>
      </div>

      <div id="forms-div" class="container w-50">
          <form action="change-user-info.php" method="POST">
            <div class="form-group">
              <label for="postal-code-input">Posta Kodu</label>  
              <input type="text" name="input-value" value="<?php echo $UserPostalCode ?>" id="city-input" class="form-control"/>

              <input type="hidden" name="ID-input" value=<?php echo $UserID?>/>
              <input type="hidden" name="column-name" value="postal_code"/>
            </div>

            <div id="button-div" class="container">
              <button class="btn btn-primary">Posta Kodu Değiştir</button>
            </div>
          </form>
      </div>
    </div>


    <br><br><br><br><br><br><br><br>

    <div id="header-div" class="container-fluid">
      <h1 id="header">Siparişler</h1>
      <br><br>
    </div>


    <div id="orders-container" class="container-fluid">

        <!--Siparişlerin listelenmesi-->
      <?php
      
        for($i=0;$i<count($OrderIDArray);$i++){

           echo "<div id='order-div' class='container-fluid pt-4 d-flex flex-wrap justfiy-content-center flex-column'><div id='order-information-div' class='container-fluid d-flex justify-content-center align-items-center'><div id='order-cell' class='container d-flex flex-wrap justify-content-center align-items-center flex-column'><p id='order-cell-header'>Sipariş ID</p><p id='order-cell-info'><a href='display-order.php?order_id=$OrderIDArray[$i]'>$OrderIDArray[$i]</a></p></div><div id='order-cell' class='container d-flex flex-wrap justify-content-start align-items-center flex-column'><p id='order-cell-header'>Toplam Fiyat</p><p id='order-cell-info'>$TotalPriceArray[$i] TL</p></div><div id='order-cell' class='container d-flex flex-wrap justify-content-start align-items-center flex-column'><p id='order-cell-header'>Ürün Sayısı</p><p id='order-cell-info'>$OrderCountArray[$i]</p></div><div id='order-cell' class='container d-flex flex-wrap justify-content-start align-items-center flex-column'><p id='order-cell-header'>Sipariş Tarihi</p><p id='order-cell-info'>$OrderDateArray[$i]</p></div><div id='order-cell' class='container d-flex flex-wrap justify-content-start align-items-center flex-column'><p id='order-cell-header'>Durum</p><p style='color:$OrderStatusColorArray[$i]' id='order-cell-info'>$OrderStatusArray[$i]</p></div></div></div>";
        }
  
      ?>

    </div>



    <br><br><br><br><br><br><br><br>

    <div id="header-div" class="container-fluid">
      <h1 id="header">Önceki Siparişler</h1>
      <br><br>
    </div>


    <div id="previous-orders-container" class="container-fluid">

     <?php

        //Önceki siparişlerin listelenmesi
        for($i=0;$i<count($PreviousOrderIDArray);$i++){

          echo "<div id='order-div' class='container-fluid pt-4 d-flex flex-wrap justfiy-content-center flex-column'><div id='order-information-div' class='container-fluid d-flex justify-content-center align-items-center'><div id='order-cell' class='container d-flex flex-wrap justify-content-center align-items-center flex-column'><p id='order-cell-header'>Sipariş ID</p><p id='order-cell-info'><a href='display-previous-order.php?previous_order_id=$PreviousOrderIDArray[$i]'>$PreviousOrderIDArray[$i]</a></p></div><div id='order-cell' class='container d-flex flex-wrap justify-content-start align-items-center flex-column'><p id='order-cell-header'>Toplam Fiyat</p><p id='order-cell-info'>$PreviousTotalPriceArray[$i] TL</p></div><div id='order-cell' class='container d-flex flex-wrap justify-content-start align-items-center flex-column'><p id='order-cell-header'>Ürün Sayısı</p><p id='order-cell-info'>$PreviousOrderCountArray[$i]</p></div><div id='order-cell' class='container d-flex flex-wrap justify-content-start align-items-center flex-column'><p id='order-cell-header'>Sipariş Tarihi</p><p id='order-cell-info'>$PreviousOrderDateArray[$i]</p></div><div id='order-cell' class='container d-flex flex-wrap justify-content-start align-items-center flex-column'><p id='order-cell-header'>Durum</p><p style='color:green' id='order-cell-info'>Teslim Edildi</p></div></div></div>";
        }
     ?>
    </div>

</body>
<script>
</script>
</html>




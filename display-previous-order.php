<?php

    $OrderID=$_GET['previous_order_id'];

    session_start();

    // Database bağlantısı
    $conn = new mysqli("localhost", "root", "", "phpprojesidatabase");
  
    if ($conn->connect_error) {
        echo "<script>alert('DB bağlanamadı!')</script>";
    }


    $PreviousorderFetcher=$conn->query("SELECT * FROM previousorders WHERE PreviousOrdersID=$OrderID");

    if($row=$PreviousorderFetcher->fetch_assoc()){

        $TotalPrice=$row['TotalPrice'];
        $OrderDate=$row['OrderDate'];
        $Products=$row['Products'];
        $Address=$row['ShippingAddress'];
        $BillingAddress=$row['BillingAddress'];
        $city=$row['City'];
        $Postcode=$row['PostalCode'];
        $Cardnumber=$row['Cardnumber'];
        $Cardname=$row['Cardname'];
        $CVC=$row['CVC'];

        
        //Ürünlerin arraylere ayrılıp [] işaretlerinden ayırılması
        $ProductArray=explode("/",$Products);

        for($i=0;$i<count($ProductArray);$i++){

            $ProductArray[$i]=explode(",",substr($ProductArray[$i],1,strlen($ProductArray[$i])-2));
        }


        $ProductIDArray=array();

        //Ürünlerin ID'lerinin ayırılarak sql sorgusu için birleştirilmesi
        for($i=0;$i<count($ProductArray);$i++){

            array_push($ProductIDArray,$ProductArray[$i][0]);
        }


        $ProductIDText=join(",",$ProductIDArray);

        //Ürünlerin adlarının ve fiyatlarının alınması
        $ProductNameAndPriceFetcher=$conn->query("SELECT GROUP_CONCAT(product_name) as product_names,GROUP_CONCAT(price) as prices FROM products WHERE Products.product_id IN($ProductIDText)");

        if($row_2=$ProductNameAndPriceFetcher->fetch_assoc()){

            $ProductnamesArray=explode(",",$row_2['product_names']);
            $PricesArray=explode(",",$row_2['prices']);
        }
    }
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Sipariş Göster</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel='stylesheet' type='text/css' media='screen' href="style/display-order.css?v=<?php echo time(); ?>">
    <script src='main.js'></script>
</head>
<body>

    <div id="order-info-div" class="container-fluid pt-5 d-flex justify-content-center align-items-center">

        <div id="order-cell" class="container w-25 d-flex justify-content-center align-items-center flex-column">
            <h1>Sipariş ID</h1>
            <p><?php echo $OrderID?></p>
        </div>

        <div id="order-cell" class="container w-25 d-flex justify-content-center align-items-center flex-column">
            <h1>Toplam Fiyat</h1>
            <p><?php echo $TotalPrice?> TL</p>
        </div>

        <div id="order-cell" class="container w-25 d-flex justify-content-center align-items-center flex-column">
            <h1>Sipariş Tarihi</h1>
            <p><?php echo $OrderDate?></p>
        </div>

        
        <div id="order-cell" class="container w-25 d-flex justify-content-center align-items-center flex-column">
            <h1>Sipariş Durumu</h1>
            <p style="color:green">Teslim Edildi</p>
        </div>
    </div>



    <div id="order-info-div" class="container-fluid pt-5 d-flex justify-content-center align-items-center">

        <div id="order-cell" class="container w-25 d-flex justify-content-center align-items-center flex-column">
            <h1>Adres</h1>
            <p><?php echo $Address?></p>
        </div>

        <div id="order-cell" class="container w-25 d-flex justify-content-center align-items-center flex-column">
            <h1>Fatura Adresi</h1>
            <p><?php echo $BillingAddress?></p>
        </div>

        <div id="order-cell" class="container w-25 d-flex justify-content-center align-items-center flex-column">
            <h1>Şehir</h1>
            <p><?php echo $city?></p>
        </div>


        <div id="order-cell" class="container w-25 d-flex justify-content-center align-items-center flex-column">
            <h1>Posta Kodu</h1>
            <p><?php echo $Postcode?></p>
        </div>
    </div>

    

    <div id="order-info-div" class="container-fluid pt-5 d-flex justify-content-start align-items-center">

        <div id="order-cell" class="container w-25 d-flex justify-content-center align-items-center flex-column">
            <h1>Kart numarası</h1>
            <p><?php echo $Cardnumber?></p>
        </div>

        <div id="order-cell" class="container w-25 d-flex justify-content-center align-items-center flex-column">
            <h1>Kart Üzerindeki İsim</h1>
            <p><?php echo $Cardname?></p>
        </div>

        <div id="order-cell" class="container w-25 d-flex justify-content-center align-items-center flex-column">
            <h1>CVC</h1>
            <p><?php echo $CVC?></p>
        </div>
    </div>

    <br><br><br><br><br><br><br><br><br>

    <h1 class="text-center" id="products-header">Ürünler</h1>

    <br><br>

    <div id="products-container" class="container-fluid d-flex justify-content-start align-items-start flex-column">
        
        <?php

        
            //Ürünlerin listelenmesi
            for($i=0;$i<count($ProductArray);$i++){

                $ProductID=$ProductArray[$i][0];
                $Productname=$ProductnamesArray[$i];
                $ProductPrice=$PricesArray[$i];
                $ProductQuantity=$ProductArray[$i][2];
                $Productcolor=$ProductArray[$i][1];

                echo "<div id='product-div' class='container w-75 p-3 d-flex justfiy-content-start align-items-center flex-row'><div style='background-image:url(./TelefonFoto/$ProductID-1.png)' id='photo' class='container w-25'></div><div id='info-div' class='container w-75 pt-3 px-4 d-flex justify-content-start align-items-start flex-column gap-5'><a href='display-product.php?product_id=$ProductID'><h1 class=''>$Productname($Productcolor)</h1></a><br><p class=''>$ProductPrice TL</p><br><p id='quantity-text'>Adet:$ProductQuantity</p></div></div>";
            }

        ?>

    </div>

</body>
</html>
<?php

    session_start();

    //TODO:Verilen indexle birlikte ürünü bul ve kaldır

    $ProductIndex=$_GET['index'];
    $Page=$_GET['page'];

    $Email=$_SESSION['email'];

    // Database bağlantısı
    $conn = new mysqli("localhost", "root", "", "phpprojesidatabase");

    if ($conn->connect_error) {
        echo "<script>alert('DB bağlanamadı!')</script>";
    }

    //Alışveriş sepetinin çekilmesi
    $ShoppingCartFetcher=$conn->query("SELECT shopping_cart FROM users WHERE email_address='$Email'");

    if($row=$ShoppingCartFetcher->fetch_assoc()){

        $ShoppingCart=$row['shopping_cart'];
        $ShoppingCartArray=explode("/",$ShoppingCart);

        $ShoppingCartArray_2=array();

        //Sepeti arraylere ayırma ve []'lerden kurtulma
        for($i=0; $i < count($ShoppingCartArray); $i++) {
            $ShoppingCartInnerText_2=substr($ShoppingCartArray[$i],1,strlen($ShoppingCartArray[$i])-2);

            $ShoppingCartInnerTextArray=explode(",",$ShoppingCartInnerText_2);

            array_push($ShoppingCartArray_2,$ShoppingCartInnerTextArray);
        }
            

        //TODO:Eğer ürünün sayısı 1den falza ise sayıyı azalt
        if($ShoppingCartArray_2[$ProductIndex][2]!="1"){

            $NewQuantity=(string)intval($ShoppingCartArray_2[$ProductIndex][2])-1;
            $ShoppingCartArray_2[$ProductIndex][2]=$NewQuantity;
        }

        else{

            //Eğer ürünün sayısı 1 ise ürünü kaldır
            unset($ShoppingCartArray_2[$ProductIndex]);
            $ShoppingCartArray_2 = array_values($ShoppingCartArray_2); // Reindex the array
        }

        $ShoppingCartArrayToJoin=array();   
        
        //Arrayi string haline getirme
        for($i=0;$i<count($ShoppingCartArray_2);$i++){

            $ShoppingCartInnerText=join(",",$ShoppingCartArray_2[$i]);

            $ShoppingCartInnerText="[".$ShoppingCartInnerText."]";

            array_push($ShoppingCartArrayToJoin,$ShoppingCartInnerText);
        }


        $ShoppingCartString=join("/",$ShoppingCartArrayToJoin);


        //Database'de update işlemi
        $Updater=$conn->query("UPDATE users SET shopping_cart='$ShoppingCartString' WHERE email_address='$Email'");

        if($Updater){

            echo "<script>alert('Ürün kaldırıldı!');</script>";
            echo "<script>window.location.href='$Page'</script>";
        }
        
    }
?>
<?php

    session_start();

    $ColorInput=$_GET['color-input'];
    $ID=$_GET['id-input'];
    $EmailValue=$_SESSION['email'];


    // Database bağlantısı
    $conn = new mysqli("localhost", "root", "", "phpprojesidatabase");

    if ($conn->connect_error) {
      echo "<script>alert('DB bağlanamadı!')</script>";
    }

    //Eğer Email session'ı boş ise kullanıcıyı login sayfasına yönlendir
    if(empty($_SESSION['email'])){
      echo "<script>alert('Lütfen Giriş Yapın!!');</script>";
      echo "<script>window.location.href = 'login.php';</script>";
      exit;
    } 

    else{

      //Eğer renk inputu boş ise hata ver ve kullanıcıyı ürüne geri gönder
      if(empty($ColorInput)){
        echo "<script>alert('Ürün rengi seçilmedi!');</script>";
        echo "<script>window.location.href = 'display-product.php?product_id=$ID';</script>";
    
      }
      else{

        //Alışveriş sepetinin çekilmesi
        $ShopCart=$conn->query("SELECT shopping_cart FROM users WHERE email_address='$EmailValue'");

        if($row=$ShopCart->fetch_assoc()){

          $ShoppingCart=$row['shopping_cart'];


          //[ID,Renk,Adet]
          $ProductText=$ID.",".$ColorInput.","."1";

          //Ürünün sepete eklenmesi


          //Eğer alışveriş sepeti boş ise direk insertle
          if($ShoppingCart==""){

            $ShopCartInserter="UPDATE users SET shopping_cart='[$ProductText]'";

            if($conn->query($ShopCartInserter)===TRUE){

              echo "<script>alert('Ürün başarıyla eklendi!');</script>";
              echo "<script>window.location.href = 'display-product.php?product_id=$ID';</script>";
            }
            else{
              echo "<script>alert('Ürün Eklenirken bir Hata Oluştu!');</script>";
              echo "<script>window.location.href = 'display-product.php?product_id=$ID';</script>";
            }


          }

          else{
            //Değeri arraylere ayırma
            $ShoppingCartArray=explode("/",$ShoppingCart);
            $ShoppingCartArray_2=array();


            //Değerleri alt arraylere ayırma
            for($i=0;$i<count($ShoppingCartArray);$i++){
              //String'i slice yap ve splitle
              $ShoppingCartArray_2[] = explode(",",substr($ShoppingCartArray[$i], 1, -1));
            }


            //TODO:Eğer aynı renkte ve ID'de ürün varsa ürünün sayısını arttır yoksa da sepete ekle

            $MatchText=$ID.",".$ColorInput;//Eşleşme texti
            $IsProductMatched=false;//Eşleşme kontrolü

            for($i=0;$i<count($ShoppingCartArray_2);$i++){

              $MatchText_2=$ShoppingCartArray_2[$i][0].",".$ShoppingCartArray_2[$i][1];

              //Eğer eşleşme varsa sayıyı arttır

              if($MatchText==$MatchText_2){
                $IsProductMatched=true;
                break;
              }

              else {
                $IsProductMatched=false;
              }
            }


            //Eğer eşleşme yoksa yeni ürünü sepete ekle

            if($IsProductMatched){

              //Ürünün adetini arttırma
              $ShoppingCartArray_2[$i][2]=strval(intval($ShoppingCartArray_2[$i][2])+1);

              echo "<script>alert('Sayı arttıtıldı!');</script>";
            }

            else{

              //Ürünü sepete ekleme
              array_push($ShoppingCartArray_2,[$ID,$ColorInput,"1"]);
            }


            //Database'de veri güncelleme
            $DatabaseUpdateArray=array();

            //İç arrayleri String'e çevirme
            for($i=0;$i<count($ShoppingCartArray_2);$i++){

              $text=join(",",$ShoppingCartArray_2[$i]);

              array_push($DatabaseUpdateArray,"[".$text."]");
            }


            $DBUpdateText=join("/",$DatabaseUpdateArray);


            //Database'de updatelenecek textin oluşturulup database'de güncellenmesi
            $sql_2="UPDATE users SET shopping_cart='$DBUpdateText' WHERE email_address='$EmailValue'";

            
            if($conn->query($sql_2)===TRUE){
              echo "<script>alert('Ürün sepetinize başarıyla eklendi!')</script>";
              echo "<script>window.location.href = 'display-product.php?product_id=$ID';</script>";
            }

            else{
              echo "<script>alert('Ürün Eklenirken bir Hata Oluştu!');</script>";
              echo "<script>window.location.href = 'display-product.php?product_id=$ID';</script>";
            }
          }
        }


      }


    }
?>
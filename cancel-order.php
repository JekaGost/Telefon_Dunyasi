<?php

    $OrderID=$_GET['order_id'];

    // Database bağlantısı
    $conn = new mysqli("localhost", "root", "", "phpprojesidatabase");
  
    if ($conn->connect_error) {
        echo "<script>alert('DB bağlanamadı!')</script>";
    }

    //Siparişin durumunun değiştirilmesi
    $Updater="UPDATE orders SET OrderStatus='İptal Edildi' WHERE OrderID=$OrderID";


    if($conn->query($Updater)===TRUE){

        echo "<script>alert('Siparişiniz İptal Edilmiştir. Şimdi Profil Sayfasına Yönlendiriliyorsunuz...')</script>";
        echo "<script>window.location.href = 'user-profile.php';</script>";
    }
    else{
        echo "<script>alert('Bir hata oluştu')</script>";
        echo "<script>window.location.href = 'user-profile.php';</script>";
    }
?>
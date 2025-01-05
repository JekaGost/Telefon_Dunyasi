<?php

    session_start();

    // Database bağlantısı
    $conn = new mysqli("localhost", "root", "", "phpprojesidatabase");

    if ($conn->connect_error) {
        echo "<script>alert('DB bağlanamadı!')</script>";
    }

    $UserID=(int)$_POST['ID-input'];
    $ColumnName=$_POST['column-name'];
    $InputValue=$_POST['input-value'];


    echo "Column:".$InputValue."<br>".$ColumnName;
    


    //Telefon ve email değerleri 2 farklı kullanıcıda aynı olmadığı için onların öncelikle başka bir kullanıcı tarafından kullanılıp kullanılmadığına bakılması gerekir
    if($ColumnName=="email_address"){
        
        //Aynı emaili kullanan kullanıcıları bulma
        $EmailCount=$conn->query("SELECT COUNT(*) as email_count FROM users WHERE email_address='$InputValue'");

        if($row=$EmailCount->fetch_assoc()){

            $EmailCountValue=$row['email_count'];

            //Eğer email sayısı 1 ise hata ver
            if($EmailCountValue==1){
                echo "<script>alert('Bu emaile sahip bir kullanıcı bulunmaktadır.')</script>";
                echo "<script>window.location.href = 'user-profile.php';</script>";
            }
            else{

                $sql="UPDATE users SET email_address='$InputValue' WHERE user_id=$UserID";

                if($conn->query($sql)===TRUE){

                    echo "<script>alert('Emailiniz başarıyla değiştirildi. Giriş sayfasına yönlendirliyorsunuz')</script>";
                    echo "<script>window.location.href = 'login.php';</script>";
                }

                else{
                    echo "<script>alert('Emailiniz değiştirilirken bir hata oluştu')</script>";
                    echo "<script>window.location.href = 'user-profile.php';</script>";
                }
            }
        }
    }

    else if($ColumnName=="phone_number"){

        //Aynı telefona sahip kullanıcıları bul
        $PhoneCount=$conn->query("SELECT COUNT(*) as phone_count FROM users WHERE phone_number='$InputValue'");

        if($row_2=$PhoneCount->fetch_assoc()){

            $PhoneCountValue=$row_2['phone_count'];

            if($PhoneCountValue==1){

                echo "<script>alert('Bu telefona sahip bir kullanıcı bulunmaktadır.')</script>";
                echo "<script>window.location.href = 'user-profile.php';</script>";
            }

            else{

                $sql_2="UPDATE users SET phone_number='$InputValue' WHERE user_id=$UserID";

                if($conn->query($sql_2)===TRUE){

                    echo "<script>alert('Telefonunuz başarıyla değiştirildi. Giriş sayfasına yönlendirliyorsunuz')</script>";
                    echo "<script>window.location.href = 'login.php';</script>";
                }

                else{
                    echo "<script>alert('Telefonunuz değiştirilirken bir hata oluştu')</script>";
                    echo "<script>window.location.href = 'user-profile.php';</script>";
                }
            }
        }

    }

    else{

        //Diğer verilerin değişimi
        $DBUpdate="UPDATE users SET $ColumnName='$InputValue' WHERE user_id=$UserID";

        if($conn->query($DBUpdate)===TRUE){

            echo "<script>alert('Veri başarıyla değiştirildi. Kullanıcı sayfasına geri dönüyorsunuz')</script>";
            echo "<script>window.location.href = 'user-profile.php';</script>";
        }
    }
?>

<?php
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Adres Bilgilerini Değiştir</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel='stylesheet' type='text/css' media='screen'  href="style/change-address-for-this-order.css?v=<?php echo time(); ?>">
    <script src='main.js'></script>
</head>
<body>
    <br>

    <h1 id="header" class="text-center">Adres Bilgilerini Değiştir</h1>

    <br><br><br>

    <div style="justify-content:space-around;" id="change-info-div" class="container-fluid d-flex flex-wrap">

    <form method="POST">
        <div class="form-group">
            <label for="exampleInputPassword1">Kart Üzerindeki İsim</label>
            <input name="Cardname" required type="text" value="<?php echo $_SESSION['card_name']?>" class="form-control" id="exampleInputPassword1">
        </div>


        <div class="form-group">
            <label for="exampleInputPassword1">Kart Numarası</label>
            <input name="CardNumber" required pattern="[0-9]{16}" type="text" value="<?php echo $_SESSION['card_number']?>" class="form-control" id="exampleInputPassword1">
        </div>

        <div class="form-group">
            <label for="exampleInputPassword1">CVC</label>
            <input name="CVC" required pattern="[0-9]{3}" type="text" value="<?php echo $_SESSION['CVC'] ?>" class="form-control" id="exampleInputPassword1">
        </div>


        <div id="button-div" class="container-fluid d-flex justify-content-center align-items-center">
            <button type="submit" class="btn btn-primary">Değişimi Onayla</button>
        </div>


    </form>


    </div>


</body>
</html>


<?php

    if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['Cardname'], $_POST['CardNumber'],$_POST['CVC'])){

        $_SESSION['card_number']=$_POST['CardNumber'];
        $_SESSION['card_name']=$_POST['Cardname'];
        $_SESSION['CVC']=$_POST['CVC'];

        echo "<script>alert('Veriler Değişti!'); window.location.href='proceed-checkout.php'</script>";
    }
?>
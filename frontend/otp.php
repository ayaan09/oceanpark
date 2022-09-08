<?php

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
    <title></title>
  </head>
  <body>
    <div class="wrapper bg-white">
    <div class="h2 text-center">FoodNation</div>
    <div class="h4 text-muted text-center pt-2">An OTP has been sent to your email</div>
    <form method="post" class="pt-3">
    <div class="form-group py-2">
            <div class="input-field"> <span class="far fa-user p-2"></span> <input type="text" placeholder="Please Enter Your OTP" name="otp"> </div>
        </div>
        <button type="submit" name="verify" class="btn btn-block text-center my-3">Verify</button>
    </form>
</div>

<?php
  if(isset($_POST["verify"])){
    require_once('../includes/functions.inc.php');
        $otp_rcv = $_POST["otp"];
        validateOTP($otp_rcv);
    } 
?>

  </body>
</html>

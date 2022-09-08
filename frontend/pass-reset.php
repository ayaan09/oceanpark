
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
    <div class="h2 text-center">Ocean Park</div>
    <div class="h4 text-muted text-center pt-2">Reset Password</div>
    <form method="post" class="pt-3" action="../includes/reset.inc.php">
    <div class="form-group py-2">
            <div class="input-field"> <span class="far fa-user p-2"></span> <input type="text" placeholder="Please Enter Your Email" name="email"> </div>
        </div>
        <button type="submit" name="verify" class="btn btn-block text-center my-3">Verify</button>
    </form>
</div>



  </body>
</html>

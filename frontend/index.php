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
    <div class="h4 text-muted text-center pt-2">Enter your login details</div>
    <form id= "form" action="../includes/login.inc.php" method="post" class="pt-3">
        <div class="form-group py-2">
            <div class="input-field"> <span class="far fa-user p-2"></span> <input type="text" placeholder="Username" name="username"> </div>
        </div>
        <div class="form-group py-1 pb-2">
            <div class="input-field"> <span class="fas fa-lock p-2"></span> <input type="password" placeholder="Enter your Password" name="password"> <button class="btn bg-white text-muted"> <span class="far fa-eye-slash"></span> </button> </div>
        </div>
        <div class="d-flex align-items-start">
            <div class="ml-auto"> <a href="pass-reset.php" id="forgot">Forgot Password?</a> </div>
            <input name="submitted" hidden></input>
        </div> <button type= "submit" name="btnSubmit" class="btn btn-block text-center my-3">Log in</button>
        <div class="text-center pt-3 text-muted">Not a member? <a href="signup.php">Sign up</a></div>
      </form>


      <?php
 
// error check 
if(isset($_GET["error"])){
  echo "<p style='color:red;text-align:center;'>Invalid Username or Password<p>";
}

if(isset($_GET["success"])){
  echo "<p style='color:green;text-align:center;'>You have successfully registered! Please sign in<p>";
}
if(isset($_GET["resetpass"])){
  echo "<p style='color:blue;text-align:center;'>Please Check Your Email<p>";
}


?>
</div>

  </body>
</html>

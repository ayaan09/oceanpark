<?php
  require_once('../includes/db.inc.php');
  if(isset($_GET["reset"])){
      $resetval=$_GET["reset"];
      $sql = "SELECT email FROM tempvariables WHERE otp = ?"; 
      $stmt =mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $sql)){
          exit();
      }
  
      mysqli_stmt_bind_param($stmt, "s",  $resetval);
      mysqli_stmt_execute($stmt);
  
      $resultsData = mysqli_stmt_get_result($stmt);
      $row = mysqli_fetch_assoc($resultsData);
      if(!isset($row)){
          echo "Invalid Email";
          exit();
      }
      mysqli_stmt_close($stmt);
    } 
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
    <div class="h4 text-muted text-center pt-2">Reset Password</div>
    <form method="post" class="pt-3">
    <div class="form-group py-2">
            <div class="input-field"> <span class="far fa-user p-2"></span> <input type="password" placeholder="Please Enter Your New Password" name="password"> </div>
        </div>
        <button type="submit" name="resetpass" class="btn btn-block text-center my-3">Submit</button>
    </form>
</div>
  </body>

  <?php
  if(isset($_POST['resetpass'])){
    $password = $_POST['password'];
    $passwordHashed = password_hash($password, PASSWORD_DEFAULT);
    $userid = $row['email'];
    $sql = "UPDATE users SET usersPwd = ? WHERE usersEmail = ?;";
    $stmt =mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../frontend/signup.php?error=insert");
        exit();
    }
    
    mysqli_stmt_bind_param($stmt, "ss", $passwordHashed, $userid);
    $seql = "DELETE FROM tempvariables;";
    if(mysqli_query($conn, $seql)){
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ../frontend/index.php");
    }
  }

  ?>
</html>

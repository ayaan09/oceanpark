<?php
include_once('navbar.php');
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="orders.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  </head>

<body  style="color:white;  background-image: url('rollercoaster.png');">
  

 
 <div style='width: 850px; position:relative; align-items: center; margin-left:300px; margin-top:50px;'>
 <h4 style='margin-top:10px;margin-bottom:20px;padding:20px; border-bottom: 2px solid red;text-align:center;'>Your Cart</h4>
 <div style='color:black !important;background-color:#D1D1D1; padding:8px 30px; margin-bottom:10px'>
 <span style='font-weight: bold; width:250px; margin-left: 20px; margin-right:200px;'>Item name</span>
 <span style='font-weight: bold; width:250px;margin-right:200px;' >Price</span>
 <span style='font-weight: bold;width:250px;'>Quantity</span>
</div>

<?php
 $food_quantity = [];
  require_once('../includes/db.inc.php');
  $totalprice = 0;
  $sql = "SELECT * FROM cart WHERE usersId=$_SESSION[userid];";
  $results = mysqli_query($conn, $sql);
  $cartitems = mysqli_fetch_all($results, MYSQLI_ASSOC);
  mysqli_free_result($results);
  for ($x = 0; $x <count($cartitems); $x++) {
    $r = $cartitems[$x]['foodId'];
    if(!isset($food_quantity[$r])){
      $food_quantity[$r] =1;
    }else{
      $food_quantity[$r] +=1;
    }
   
    $totalprice = $totalprice + $cartitems[$x]['foodPrice'];
    $array_name[$x] = $cartitems[$x]['foodName'];
    $array_price[$x] = $cartitems[$x]['foodPrice'];
    $food_foodid[$x] = $cartitems[$x]['foodId'];
    $food_id[$x] = $cartitems[$x]['id'];
  }

  if(isset($_GET["order"])){
    echo "<h2 style='color:green;text-align:center;'>Your Order Has Been Placed!</h2>";
  }
  if(isset($_GET["payment"])){
    echo "<h3 style='color:red;text-align:center;'>Your Payment has Failed</h3>";
  }
  function map_cart($a, $b, $c, $d){
  $e = $GLOBALS['food_quantity'] ;
  $f = $e[$d];
   echo" <div style='background-color:#D1D1D1; padding:8px 30px; margin-bottom:10px;color:black !important;'>
   <span style='font-weight: bold; display:inline-block;width:285px;margin-left:20px;'>$a</span>
   <span style='font-weight: bold; display:inline-block;width:240px;' >$b</span>
   <span style='font-weight: bold; display:inline-block;width:100px;'>1</span>
   <form method='post' style='display:inline'>
   <input name='id' value=$c  hidden></input>
   <button type='submit' name='removecart' class='btn btn-danger'>Remove</button>
   </form>
  </div>";

  }
  
  if(isset($_POST["removecart"])){
      $id_to_del = $_POST['id'];
    require_once('../includes/db.inc.php');
    $sql = "DELETE FROM cart WHERE id=$id_to_del;";
    if(!mysqli_query($conn, $sql)){
        echo "failed delete";
    }
    header("Refresh:0");
} 
if(count($cartitems)!==0){
  $new_arr = array_map('map_cart',$array_name, $array_price, $food_id, $food_foodid);}
  echo "<h5 style='margin-top:30px;'>Total Bill: BDT $totalprice<h5>";
  
?>
<div class="row checkout">
  <div class="col-75">
    <div class="container">
      <form action="../includes/order.inc.php" method="post">

          <div class="col-50">
            <h3>Payment</h3>
            <label for="fname">Accepted Cards</label>
            <div class="icon-container">
              <i class="fa fa-cc-visa" style="color:navy;"></i>
              <i class="fa fa-cc-amex" style="color:blue;"></i>
              <i class="fa fa-cc-mastercard" style="color:red;"></i>
              <i class="fa fa-cc-discover" style="color:orange;"></i>
            </div>
            <label for="cname">Name on Card</label>
            <input type="text" id="cname" name="cardname" placeholder="John More Doe">
            <label for="ccnum">Credit card number</label>
            <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444">

            <div class="row">
              <div class="col-50">
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="cvv" placeholder="352">
              </div>
            </div>
          </div>
          <button type="submit" name="placeorder" class="btn btn-danger btn-block text-center my-3">Place Order</button>
</form>
</div>
</body>


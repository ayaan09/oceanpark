<?php
session_start();
require_once('db.inc.php');
$orders="";
$totalprice=0;
$sql = "SELECT * FROM cart WHERE usersId=$_SESSION[userid];";
$results = mysqli_query($conn, $sql);
$cartitems = mysqli_fetch_all($results, MYSQLI_ASSOC);
mysqli_free_result($results);
for ($x = 0; $x <count($cartitems); $x++) {
$food_name = $cartitems[$x]['foodName'];
$food_price = $cartitems[$x]['foodPrice'];
$orders = $orders . "<span style=\"display:block;\"><b><span style=\"min-width:350px;display:inline-block;\">1x $food_name</span><span style=\"min-width:100px;display:inline-block;\">BDT $food_price</span></b><span>";
$totalprice = $totalprice + $cartitems[$x]['foodPrice'];

}
$discount = $totalprice*0.1;
$discounted_price = $totalprice - $discount;
$name =$_SESSION["username"];


if(isset($_POST["placeorder"])){
    $payment_method=$_POST["cardname"];
    $acc_number = $_POST["cardnumber"];
    $pass_ = $_POST["cvv"];
    $mail =
"<body>
    <div style=\"display: flex;flex-direction: row;flex-wrap: wrap;justify-content: center;align-items: center;width:1180px; background-color:#FAFAFA; height:580px;\">
      <div style=\"margin-left:auto; margin-right: auto; padding:30px;width:600px; background-color:#FFFFFF; height:380px;\"class=\"\">
        <h2>Hello $name,</h2>
        <span style=\"display:block;\">Thank you for Placing an Order!</span><br></br>
        <span style=\"display:block;\">Please Check your Order<span>
          <br></br>
          $orders
          <div style=\"height: 20px;border-bottom:1px solid black\">
            </div><br>
            <span style=\"display:block;\"><b><span style=\"min-width:350px;display:inline-block;\">Total Bill</span><span style=\"min-width:100px;display:inline-block;\">BDT $totalprice</span></b><span>
            <span style=\"display:block;\"><b><span style=\"min-width:350px;display:inline-block;\">Coinpurse Card Discount </span><span style=\"min-width:100px;display:inline-block;\">BDT $discount</span></b><span>

            <span style=\"display:block;\"><b><span style=\"min-width:350px;display:inline-block;\">Discounted Bill </span><span style=\"min-width:100px;display:inline-block;\">BDT $discounted_price</span></b><span>
      </div>
      <span style=\"position: absolute;bottom:165px;color:gray; font-size:0.7rem;\">If you did not place this order, please report this incident.</span>
    </div>
  </body>";
    require_once('db.inc.php');
    $id_to_del = $_SESSION['userid'];
    $email = $_SESSION['useremail'];
    $headers = "From: OceanPark <nation_food@yahoo.com>\r\n";
    $headers.= "MIME-Version: 1.0\r\n";
    $headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";

      $url = 'http://127.0.0.1:8080/authorize_payment';
      $data = array("payee_id"=>"6",
        "payer_id"=>$acc_number,
        "pwd"=>$pass_,
        "amount"=> $discounted_price,
        "type"=> "withdraw",
      ); 
        $content = json_encode($data);
        
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
                array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        
        $json_response = curl_exec($curl);
        
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $response = json_decode($json_response, true);
        if ( $status != 200 ) {
            die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
        }
        else{
          $response_from_bank= $response["transaction"];
          if($response_from_bank=='ok'){
                  $mail = mail($email, 'Your Order Has Been Placed!', $mail, $headers);
       
                  if(!$mail){
                    header("location: ../frontend/orders.php?email=failed");
                  }
                  else{
                $sql = "DELETE FROM cart WHERE usersId=$id_to_del;";
                if(!mysqli_query($conn, $sql)){
                    echo "failed delete";
                }
            }
          header("location: ../frontend/orders.php?order=successful");
          }else{
            header("location: ../frontend/orders.php?payment=error;res=$response_from_bank");
          }
        }  
        
        curl_close($curl);
        

}

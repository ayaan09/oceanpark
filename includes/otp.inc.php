<?php


if(isset($_POST["submit"])){

    $name = $_POST["name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    // do verification here
    require_once('functions.inc.php');
    require_once('db.inc.php');
    $unameExists = uidExists($conn, $username, $username);
    $emailExists = uidExists($conn, $email, $email);
    if(isset($unameExists['usersUid'])){
      header("location: ../frontend/signup.php?username=taken");;
    }
    elseif(isset($emailExists['usersEmail'])){
      header("location: ../frontend/signup.php?takenemail=true");;
    }
    else{
    $otp = getName(10);
    savetemp($conn, $otp, $name, $email,$username, $password);

    $emailbody = "
      <body>
        <div style=\"display: flex;flex-direction: row;flex-wrap: wrap;justify-content: center;align-items: center;width:1180px; background-color:#FAFAFA; height:580px;\">
        <div style=\"margin-left:auto; margin-right:auto\">
        <span  style=\"display:block; text-align:center; font-size:2rem;font-family:cursive; font-weight:bolder;\">~OCEANPARK~</span>
          <div style=\"margin-top:30px; margin-left:auto; margin-right: auto; padding:30px;width:600px; background-color:#FFFFFF; height:380px;\"class=\"\">
            <h2>Hello $name,</h2>
            <span style=\"display:block;\">Thank you for creating a OceanPark account!</span><br></br>
            <span style=\"display:block;\">Your one-time <b>Access Token is:</b><span>
              <div style=\"position: relative; margin-left:110px; margin-top:40px;border:1px black solid;text-align:center;width:200px;
              padding:5px;\" class=\"\">
                <b>$otp</b>
              </div>
              <br></br>
              <span style=\"display:block;\">This one-time <b>Access Token </b>expires if you refresh the signup page<span>
                <br></br><br></br>
                <span style=\"display:block;\">Please copy & paste the Access Token into the input field on the Complete<span>
                <span style=\"display:block;\">Verification page in order to complete your account verification.</span>
          </div>
          <span style=\"color:gray; font-size:0.7rem;\">If you did not attempt to create an account, you may ignore this email or report this incident.</span>
        </div>
        </div>
      </body>
    </html>";
  $headers = "From: OceanPark <nation_food@yahoo.com>\r\n";
  $headers.= "MIME-Version: 1.0\r\n";
  $headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    $mail = mail($email, 'Welcome to OceanPark', $emailbody, $headers);
    if(!$mail){
      header("location: ../frontend/signup.php?email=failed");
    }
    header("location: ../frontend/otp.php");
}
}
else{
    header("location: ../frontend/signup.php ");
    exit();
}

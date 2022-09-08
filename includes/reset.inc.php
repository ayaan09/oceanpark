<?php
if(isset($_POST['verify'])){
    $email = $_POST['email'];
    require_once('functions.inc.php');
    require_once('db.inc.php');
    $emailExists = uidExists($conn, $email, $email);
    if(isset($emailExists['usersEmail'])){
    $name= $emailExists['usersName'];
    require_once('functions.inc.php');
    $otp = getName(10);
    savetemp($conn, $otp, $name, $email,"N/A", "N/A");
$emailbody = "
      <body>
        <div style=\"display: flex;flex-direction: row;flex-wrap: wrap;justify-content: center;align-items: center;width:1180px; background-color:#FAFAFA; height:580px;\">
        <div style=\"margin-left:auto; margin-right:auto\"> 
        <span  style=\"display:block; text-align:center; font-size:2rem;font-family:cursive; font-weight:bolder;\">~OCEANPARK~</span>
          <div style=\"margin-top:30px; margin-left:auto; margin-right: auto; padding:30px;width:600px; background-color:#FFFFFF; height:380px;\"class=\"\">
            <h2>Hello $name,</h2>
            <span style=\"display:block;\">Please Follow the Link to Reset Your Password</span><br></br>
              <div style=\"background-color='blue';position: relative; margin-left:110px; margin-top:40px;border:1px black solid;text-align:center;width:200px;
              padding:5px;\" class=\"\">
                <a href='http://localhost/ocean-park/frontend/resetpage.php?reset=$otp'>Reset Your Password</a>
              </div>
          </div>
          <span style=\"color:gray; font-size:0.7rem;\">If you did not attempt to reset your password report this incident.</span>
        </div>
        </div>
      </body>
    </html>";
  $headers = "From: Foodnation <nation_food@yahoo.com>\r\n";
  $headers.= "MIME-Version: 1.0\r\n";
  $headers.= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    $mail = mail($email, 'Reset Your Password', $emailbody, $headers);
    if(!$mail){
      header("location: ../frontend/signup.php?email=failed");
    }
}
else{
    echo "Invalid Email";
}
header("location: ../frontend/index.php?resetpass=true");
}
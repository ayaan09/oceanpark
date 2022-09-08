<?php


if(isset($_POST["btnSubmit"])){
   
    $username = $_POST["username"];
    $password = $_POST["password"];
    // do verification here
    require_once('functions.inc.php'); 
    require_once('db.inc.php');
    loginUser($conn, $username, $password);
} 
else{
    header("location: ../frontend/index.php");
    exit();
}

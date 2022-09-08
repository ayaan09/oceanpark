<?php

function getName($n) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';

    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
    return $randomString;
}


function validateOTP($otp_rcv){
    require_once('../includes/db.inc.php');
    $sql = "SELECT * FROM tempvariables;";
    $results = mysqli_query($conn, $sql);
    $tempitems = mysqli_fetch_all($results, MYSQLI_ASSOC);
    if($otp_rcv==$tempitems[0]['otp']){
        $name = $tempitems[0]['u_name'];
        $email = $tempitems[0]['email'];
        $username = $tempitems[0]['username'];
        $password = $tempitems[0]['pwd'];
        require_once('db.inc.php');
        $seql = "DELETE FROM tempvariables;";
        if(mysqli_query($conn, $seql)){
            createUser($conn, $name, $email, $username, $password);
        }
    }else{
        $sql = "DELETE FROM tempvariables;";
        if(mysqli_query($conn, $sql)){
            header("location: ../frontend/signup.php?error=otpfail");
            exit();
        }
    }
}

function createUser($conn, $name, $email, $username, $password){

    $sql = "INSERT INTO users (usersName, usersEmail, usersUid, usersPwd) VALUES (?, ?, ?, ?);";
    $stmt =mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../frontend/signup.php?error=insert");
        exit();
    }
    $passwordHashed = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $passwordHashed);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../frontend/index.php?success=true");
}


function uidExists($conn, $username, $email){
    $sql = "SELECT * FROM users WHERE usersUid = ? OR UsersEmail=?;";
    $stmt =mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../frontend/index.php?connection=fail");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultsData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultsData)){
        return $row;
    }else{
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function loginUser($conn, $username, $password){
    $uidExists = uidExists($conn, $username, $username);

    if($uidExists === false){
        header("location: ../frontend/index.php?error=invalidcredentials");
        exit();
    }

    $pwdhashed = $uidExists["usersPwd"]; //fetched password from database
    $checkPwd = password_verify($password, $pwdhashed); //$password is fetched password from form

    if($checkPwd === false){
        header("location: ../frontend/index.php?error=invalidcredentials");
        exit();
    }
    else if ($checkPwd === true){
        session_start();
        $_SESSION["userid"] = $uidExists["usersID"];
        $_SESSION["username"] = $uidExists["usersName"];
        $_SESSION["useremail"] = $uidExists["usersEmail"];
        header("location: ../frontend/home.php");
        exit();
    }
}
function addCart($conn, $name, $price, $fooditem, $userId){
    $name = str_replace('#',' ', $name);
    $sql = "INSERT INTO cart (foodName, foodPrice, foodId, usersId) VALUES (?, ?, ?, ?);";
    $stmt =mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../frontend/menu.php?error=failtoadd");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "siii", $name, $price, $fooditem, $userId);
    mysqli_stmt_execute($stmt);
    header("Refresh:0");
    mysqli_stmt_close($stmt);
}

function savetemp($conn, $otp, $name, $email, $username, $password){
    $sql = "INSERT INTO tempvariables (otp, u_name, email, username, pwd) VALUES (?, ?, ?, ?, ?);";
    $stmt =mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../frontend/menu.php?error=failure");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sssss", $otp, $name, $email, $username, $password);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

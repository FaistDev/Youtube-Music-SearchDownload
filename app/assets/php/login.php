<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 02.02.2020
 * Time: 13:53
 */

include "conn.php";

//Prepare Statement
$loginStmt = mysqli_prepare($conn, "SELECT `Password`,`ID` FROM `User` WHERE `Username`= ?");

mysqli_stmt_bind_param($loginStmt, "s", $_POST["username"]);
mysqli_stmt_bind_result($loginStmt, $col_pwd, $col_id);

mysqli_stmt_execute($loginStmt);
mysqli_stmt_store_result($loginStmt);


if (mysqli_stmt_num_rows($loginStmt) > 0) {

    while (mysqli_stmt_fetch($loginStmt)) {
        if (password_verify($_POST["password"], $col_pwd)) {
            $token = getUserToken($col_id);
            setcookie("token",$token,time()+157680000,"/YoutubeMusicStreamer/");
            echo "success";
        } else {
            die("Wrong Password!");
        }
    }
} else {
    die("Wrong Username!");
}

$tries = 0;
function getUserToken($userID){
    global $conn,$tries;

    $token = substr(md5(openssl_random_pseudo_bytes(30)), -30);

    //Prepare Statement
    $loginStmt2 = mysqli_prepare($conn, "INSERT INTO `UserToken`(`Token`, `UserID`) VALUES (?,?)");

    mysqli_stmt_bind_param($loginStmt2, "ss", $token,$userID);

    if (mysqli_stmt_execute($loginStmt2)) {
        return $token;
    } else {
        if($tries<10){
            $tries++;
            return getUserToken($userID);
        }else{
            die("Failed");
        }
    }
}
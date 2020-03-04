<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 02.02.2020
 * Time: 13:59
 */

include "conn.php";

if(!isset($_COOKIE["token"])){
    //die("no token");
    die("<script>window.location.href='index.php';</script>");
}

//Prepare Statement
$loginStmt = mysqli_prepare($conn, "SELECT UserToken.Token
FROM UserToken 
WHERE UserToken.Token=?");

mysqli_stmt_bind_param($loginStmt, "s",$_COOKIE["token"]);
mysqli_stmt_bind_result($loginStmt, $col_token);

if(!mysqli_stmt_execute($loginStmt)){
    echo "Error: ".mysqli_error($conn);
}
mysqli_stmt_store_result($loginStmt);

//echo "Rows:".mysqli_stmt_num_rows($loginStmt);

if (mysqli_stmt_num_rows($loginStmt) != 1) {
    //die("no server");
    die("<script>window.location.href='index.php';</script>");
}
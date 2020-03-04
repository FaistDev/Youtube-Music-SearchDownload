<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 02.02.2020
 * Time: 22:09
 */

include "conn.php";

$loginStmt = mysqli_prepare($conn, "INSERT INTO `Playlist`(`UserID`, `Name`) VALUES ((SELECT UserToken.UserID FROM UserToken WHERE UserToken.Token=?),?)");

mysqli_stmt_bind_param($loginStmt, "ss",$_COOKIE["token"],$_POST["name"]);
//mysqli_stmt_bind_result($loginStmt,$col_id,$col_name);

if(mysqli_stmt_execute($loginStmt)){
    echo "success";
}else{
    die("Error: ".mysqli_error($conn));
}
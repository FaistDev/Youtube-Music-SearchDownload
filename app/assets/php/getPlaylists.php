<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 02.02.2020
 * Time: 14:59
 */

include "conn.php";

$loginStmt = mysqli_prepare($conn, "SELECT `ID`,`Name` FROM `Playlist` WHERE `UserID`=(SELECT UserToken.UserID FROM UserToken WHERE UserToken.Token=?)");

mysqli_stmt_bind_param($loginStmt, "s",$_COOKIE["token"]);
mysqli_stmt_bind_result($loginStmt,$col_id,$col_name);

mysqli_stmt_execute($loginStmt);
mysqli_stmt_store_result($loginStmt);

$output='{"playlists":[';
$c=0;
if (mysqli_stmt_num_rows($loginStmt) > 0) {

    while (mysqli_stmt_fetch($loginStmt)) {
        if($c==0){
            $output.='{"id":'.$col_id.',"name":"'.$col_name.'"}';
        }else{
            $output.=',{"id":'.$col_id.',"name":"'.$col_name.'"}';
        }
        $c++;
    }
}
$output.=']}';
echo $output;
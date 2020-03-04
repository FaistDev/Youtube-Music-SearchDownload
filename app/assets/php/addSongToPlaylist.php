<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 03.02.2020
 * Time: 14:40
 */

include "conn.php";

checkPermission();

$loginStmt = mysqli_prepare($conn, "INSERT INTO `PlaylistSong`(`PlaylistID`, `SongID`) VALUES (?,?)");

mysqli_stmt_bind_param($loginStmt, "ss",$_POST["playlistID"],$_POST["songID"]);
//mysqli_stmt_bind_result($loginStmt,$col_id,$col_name);

if(mysqli_stmt_execute($loginStmt)){
    echo "success";
}else{
    die("Error: ".mysqli_error($conn));
}

function checkPermission(){
    global $conn;

    $loginStmt = mysqli_prepare($conn, "SELECT `ID` FROM `Playlist` WHERE `UserID`=(SELECT UserToken.UserID FROM UserToken WHERE UserToken.Token=?) AND Playlist.ID=?");

    mysqli_stmt_bind_param($loginStmt, "ss",$_COOKIE["token"],$_POST["playlistID"]);
    mysqli_stmt_bind_result($loginStmt,$col_id);

    mysqli_stmt_execute($loginStmt);
    mysqli_stmt_store_result($loginStmt);

    if (mysqli_stmt_num_rows($loginStmt) == 0) {
        die("Permission denied!");
    }
}
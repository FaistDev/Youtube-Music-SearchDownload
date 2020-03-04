<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 31.01.2020
 * Time: 22:06
 */

include "conn.php";

//echo escapeshellcmd('python3.8 ../py/downloadSong.py '.$_POST["url"]);

$command = escapeshellcmd('python3.8 ../py/downloadSong.py '.$_POST["url"]);
$output = shell_exec($command);
//echo $output;
//$output="0001.mp3";//TODO remove test and call python script
$loginStmt = mysqli_prepare($conn, "INSERT INTO `Song`(`Title`, `URL`, `Filename`) VALUES (?,?,?)");

mysqli_stmt_bind_param($loginStmt, "sss",$_POST["title"],$_POST["url"],$output);

if(mysqli_stmt_execute($loginStmt)){
    $id=mysqli_insert_id($conn);
    echo '{"file":"'.trim($output).'","id":"'.$id.'"}';
}else{
    echo "Error: ".mysqli_error($conn);
}
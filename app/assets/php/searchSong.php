<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 30.01.2020
 * Time: 09:59
 */

include "conn.php";

$words = explode(' ', $_POST["searchString"]);
$conds = array();
$query="";
foreach ($words as $val) {
    $conds[] = "`Title` LIKE '%".$val."%'";
}
$query .= implode(' AND ', $conds);

$loginStmt = mysqli_prepare($conn, "SELECT `ID`,`Filename`,`Title`,`URL` FROM `Song` WHERE ".$query);

//$search = "%".$_POST["searchString"]."%";

//mysqli_stmt_bind_param($loginStmt, "s",$search);
mysqli_stmt_bind_result($loginStmt,$col_id,$col_filename,$col_title,$col_url);

mysqli_stmt_execute($loginStmt);
mysqli_stmt_store_result($loginStmt);

$output='{"songs":[';
$c=0;
$output.='{"local":[';
if (mysqli_stmt_num_rows($loginStmt) > 0) {

    while (mysqli_stmt_fetch($loginStmt)) {
        $parts = parse_url($col_url);
        parse_str($parts['query'], $query);
        $image = $query['v'];

        if($c==0){
            $output.='{
        "id":'.$col_id.',
        "title":"'.$col_title.'",
        "filename":"'.str_replace('"','',str_replace("'","",trim($col_filename))).'",
        "url":"0",
        "image":"https://img.youtube.com/vi/'.$image.'/0.jpg"
        }';
        }else{
            $output.=',{
        "id":'.$col_id.',
        "title":"'.$col_title.'",
        "filename":"'.str_replace('"','',str_replace("'","",trim($col_filename))).'",
        "url":"0",
        "image":"https://img.youtube.com/vi/'.$image.'/0.jpg"
        }';
        }
        $c++;
    }
}
$output.=']},{"youtube":[';

    /*$output.='{
        "id":0,
        "title":"Test",
        "filename":"0",
        "url":"/watch?v=ERw2kMMHNmE"
        }';*/

    /*if($c!=0){
        $output.=",";
    }
*/
    //echo realpath("../py/searchSong.py");
    $command = escapeshellcmd('python3.8 ../py/searchSong.py '.escapeshellarg($_POST["searchString"]).' '.escapeshellarg(10).' '.escapeshellarg(0));
    //echo $command;
        //$command = escapeshellcmd('python3.8 ../py/searchSong.py '.escapeshellarg($_POST["searchString"]).' '.escapeshellarg(0).' '.escapeshellarg(10));
    $output.= shell_exec($command);

    //passthru('/usr/bin/python3 assets/py/searchSong.py '.$_POST["searchString"]);


$output.=']}]}';
echo $output;
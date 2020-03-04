<?php
/**
 * Created by PhpStorm.
 * User: Ben
 * Date: 02.02.2020
 * Time: 22:16
 */

include "conn.php";

$loginStmt = mysqli_prepare($conn, "SELECT Song.ID,`Filename`,`Title`,`URL`
FROM `Song` JOIN PlaylistSong ON Song.ID=PlaylistSong.SongID
			JOIN Playlist ON PlaylistSong.PlaylistID=Playlist.ID
WHERE Playlist.ID=?");

mysqli_stmt_bind_param($loginStmt, "s",$_POST["playlistID"]);
mysqli_stmt_bind_result($loginStmt,$col_id,$col_filename,$col_title,$col_url);

mysqli_stmt_execute($loginStmt);
mysqli_stmt_store_result($loginStmt);

$output='{"songs":[';
$c=0;
if (mysqli_stmt_num_rows($loginStmt) > 0) {

    while (mysqli_stmt_fetch($loginStmt)) {
        $parts = parse_url($col_url);
        parse_str($parts['query'], $query);
        $image = $query['v'];

        if($c==0){
            $output.='{
        "id":'.$col_id.',
        "title":"'.$col_title.'",
        "filename":"'.trim($col_filename).'",
        "url":"0",
        "image":"https://img.youtube.com/vi/'.$image.'/0.jpg"
        }';
        }else{
            $output.=',{
        "id":'.$col_id.',
        "title":"'.$col_title.'",
        "filename":"'.trim($col_filename).'",
        "url":"0",
        "image":"https://img.youtube.com/vi/'.$image.'/0.jpg"
        }';
        }
        $c++;
    }
}
$output.=']}';

echo $output;
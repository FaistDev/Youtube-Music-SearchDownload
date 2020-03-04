<?php
include "assets/php/checkLogin.php";
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="assets/js/search.js"></script>
    <script src="assets/js/play.js"></script>
    <link rel="stylesheet" href="assets/css/myPlaylists.css">
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>

<div id="header">
    <p onclick="showPlaylist(false)" id="backButton"><-</p>
    <h3>Playlists</h3>
</div>

<button id="newPlaylistButton" onclick="newPlaylist(true)">Neue Playlist</button>
<div id="playlists">

</div>

<div id="newPlaylist">
    <button onclick="newPlaylist(false)" id="closeButton_newPlaylist">X</button>
    <form onsubmit="createNewPlaylist(event)">
        <input type="text" placeholder="Name der Playlist" required id="playlistName" />
        <button type="submit">Speichern</button>
    </form>
</div>

<div id="playlistSongs">

</div>

<?php include "assets/components/songPlayer.php"; ?>

<?php include "assets/components/menu.php"; ?>

</body>
</html>
<script>
    getPlaylists();
    showSongAddToPlaylistButton(false);
    document.getElementById("shuffleButton_SongPlayer").style.display="inline-block";
    function getPlaylists() {
        showHideLoading(true);
        $.ajax({
            url: "assets/php/getPlaylists.php",
            datatype: "json",
            data: {},
            type: "POST",
            success: function (out) {
                console.log("Data: " + out);
                const data = JSON.parse(out);
                var output="";
                for(i=0;i<data.playlists.length;i++){
                    output+="<p onclick='getPlaylistSongs("+data.playlists[i].id+")'>"+data.playlists[i].name+"</p>";
                }
                document.getElementById("playlists").innerHTML=output;
                showHideLoading(false);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.error(thrownError);
                showHideLoading(false);
                //showAjaxErrorMessage(true,thrownError);
            }
        });
    }
    
    function newPlaylist(show) {
        if(show){
            document.getElementById("newPlaylist").style.display="block";
        }else{
            document.getElementById("newPlaylist").style.display="none";
        }
    }

    function showPlaylist(show) {
        if(show){
            document.getElementById("playlistSongs").style.display="block";
            document.getElementById("backButton").style.display="inline-block";
            document.getElementById("playlists").style.display="none";
        }else{
            document.getElementById("playlistSongs").style.display="none";
            document.getElementById("backButton").style.display="none";
            document.getElementById("playlists").style.display="block";
        }
    }

    function createNewPlaylist(event) {
        event.preventDefault();
        const name = document.getElementById("playlistName").value;
        showHideLoading(true);
        $.ajax({
            url: "assets/php/createNewPlaylist.php",
            datatype: "json",
            data: {name: name},
            type: "POST",
            success: function (out) {
                console.log("Data: " + out);
                showHideLoading(false);
                if(out=="success"){
                    newPlaylist(false);
                    getPlaylists();
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.error(thrownError);
                showHideLoading(false);
                //showAjaxErrorMessage(true,thrownError);
            }
        });
    }

    function getPlaylistSongs(playlistID) {
        showHideLoading(true);
        $.ajax({
            url: "assets/php/getPlaylistSongs.php",
            datatype: "json",
            data: {playlistID: playlistID},
            type: "POST",
            success: function (out) {
                console.log("Data: " + out);
                showHideLoading(false);
                const data = JSON.parse(out);
                var output="";
                for(i=0;i<data.songs.length;i++){
                    output+="<div class='song' onclick='playSong("+data.songs[i].id+",\""+data.songs[i].title+"\",\""+data.songs[i].filename+"\","+i+")'><img src='"+data.songs[i].image+"'/> <div>"+data.songs[i].title+"</div></div>";
                }
                document.getElementById("playlistSongs").innerHTML=output;
                showPlaylist(true);
                lastIndex=0;
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.error(thrownError);
                showHideLoading(false);
                //showAjaxErrorMessage(true,thrownError);
            }
        });
    }

    document.getElementById("audioController").onended = function() {
        nextSong();
    };
</script>
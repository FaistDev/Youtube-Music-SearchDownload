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
    <link href="assets/css/search.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
<form onsubmit="searchSong(event)">
    <input type="text" id="searchInput" placeholder="Search song" required/>
    <button type="submit">OK</button>
</form>

<div id="searchResults">

</div>

<div id="playlists">

</div>

<?php include "assets/components/songPlayer.php"; ?>

<?php include "assets/components/menu.php"; ?>
<script>
    showSongControls(false);
    document.getElementById("shuffleButton_SongPlayer").style.display="none";
</script>
</body>
</html>
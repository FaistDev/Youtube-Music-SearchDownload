<div id="menu">
    <a href="search.php">Suche</a>
    <a href="myPlaylists.php">Playlists</a>
</div>

<div id="loadingBackground"></div>
<img id="loadingSpinner" src="assets/img/loading.gif"/>

<script>
    function showHideLoading(show) {
        if(show){
            document.getElementById("loadingBackground").style.display="block";
            document.getElementById("loadingSpinner").style.display="block";
        }else{
            document.getElementById("loadingBackground").style.display="none";
            document.getElementById("loadingSpinner").style.display="none";
        }
    }
</script>
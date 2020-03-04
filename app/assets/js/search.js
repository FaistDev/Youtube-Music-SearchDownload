function searchSong(event) {
    event.preventDefault();
    const searchString = document.getElementById("searchInput").value;
    showHideLoading(true);
    $.ajax({
        url: "assets/php/searchSong.php",
        datatype: "json",
        data: {searchString: searchString},
        type: "POST",
        success: function (out) {
            console.log("Data: " + out);
            const data = JSON.parse(out);
            var output="<div><h3>Lokal</h3>";

            for(i=0;i<data.songs[0].local.length;i++){
                if(data.songs[0].local[i].filename!="0"){
                    output+="<div class='song' onclick='playSong("+data.songs[0].local[i].id+",\""+data.songs[0].local[i].title+"\",\""+data.songs[0].local[i].filename+"\")'><img src='"+data.songs[0].local[i].image+"'/> <div>"+data.songs[0].local[i].title+"</div><span class='addToPlaylistButton' onclick='showPlaylists("+data.songs[0].local[i].id+",event)'>+</span></div>";
                }else{
                    output+="<div class='song' onclick='downloadSong(\""+data.songs[0].local[i].title+"\",\""+data.songs[0].local[i].url+"\")'><img src='"+data.songs[0].local[i].image+"'/><div>"+data.songs[0].local[i].title+"</div></div>";
                }

            }

            output+="<h3>Youtube</h3>";

            for(i=0;i<data.songs[1].youtube.length;i++){
                if(data.songs[1].youtube[i].filename!="0"){
                    output+="<div class='song' onclick='playSong("+data.songs[1].youtube[i].id+",\""+data.songs[1].youtube[i].title+"\",\""+data.songs[1].youtube[i].filename+"\")'><img src='"+data.songs[1].youtube[i].image+"'/> <div>"+data.songs[1].youtube[i].title+"</div></div>";
                }else{
                    output+="<div class='song' onclick='downloadSong(\""+data.songs[1].youtube[i].title+"\",\""+data.songs[1].youtube[i].url+"\")'><img src='"+data.songs[1].youtube[i].image+"'/><div>"+data.songs[1].youtube[i].title+"</div></div>";
                }

            }
            output+="</div>";
            document.getElementById("searchResults").innerHTML=output;
            showHideLoading(false);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.error(thrownError);
            showHideLoading(false);
            //showAjaxErrorMessage(true,thrownError);
        }
    });
}

function downloadSong(title,url) {
    console.log("Song "+title+" download started...");
    showHideLoading(true);
    $.ajax({
        url: "assets/php/downloadSong.php",
        datatype: "json",
        data: {title: title, url: url},
        type: "POST",
        success: function (out) {
            console.log("Data: " + out);
            showHideLoading(false);
            const data = JSON.parse(out);
            try{
                playSong(data.id,title,data.file);
            }catch (e) {

            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.error(thrownError);
            showHideLoading(false);
            //showAjaxErrorMessage(true,thrownError);
        }
    });
}

function showPlaylists(songID,e) {
    e.stopPropagation();
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
                output+="<p onclick='addSongToPlaylist("+data.playlists[i].id+","+songID+")'>"+data.playlists[i].name+"</p>";
            }
            document.getElementById("playlists").innerHTML=output;
            showHidePlaylists(true);
            showHideLoading(false);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.error(thrownError);
            showHideLoading(false);
            //showAjaxErrorMessage(true,thrownError);
        }
    });
}

function addSongToPlaylist(playlistID,songID) {
    showHideLoading(true);
    $.ajax({
        url: "assets/php/addSongToPlaylist.php",
        datatype: "json",
        data: {playlistID: playlistID, songID: songID},
        type: "POST",
        success: function (out) {
            console.log("Data: " + out);
            showHideLoading(false);
            if(out=="success"){
               showHidePlaylists(false);
               alert("Zur Playlist hinzugefügt");
            }else{
                alert("Error: "+out);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.error(thrownError);
            showHideLoading(false);
            //showAjaxErrorMessage(true,thrownError);
        }
    });
}

function showHidePlaylists(show) {
    if(show){
        document.getElementById("playlists").style.display="block";
    }else{
        document.getElementById("playlists").style.display="none";
    }
}
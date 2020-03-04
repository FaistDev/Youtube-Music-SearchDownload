function playSong(id,title,filename,index) {
    const path = "data/songs/";
    alreadyPlayedSongs.push(index);
    try{
        android.playMusic("http://faistdev.ddns.net/YoutubeMusicStreamer/"+path+filename);
    }catch (e) {
        const audioController = document.getElementById("audioController");
        document.title=title;
        audioController.setAttribute("title",title);
        audioController.setAttribute("src",path+filename);
        audioController.setAttribute("songID",id);
        audioController.play();
    }




    try{
        lastIndex=index;
    }catch (e) {
        console.error(e);
    }

    document.getElementById("songTitle_SongPlayer").innerHTML=title;
    document.getElementById("addSongToPlaylistButton_SongPlayer").setAttribute("onclick","showPlaylists("+id+",event)");

}

var lastIndex=0;

function showSongControls(show) {
    if(show){
        document.getElementById("songControls").style.display="inline-block";
    }else {
        document.getElementById("songControls").style.display="none";
    }
}

function showSongAddToPlaylistButton(show) {
    if(show){
        document.getElementById("addSongToPlaylistButton_SongPlayer").style.display="inline-block";
    }else {
        document.getElementById("addSongToPlaylistButton_SongPlayer").style.display="none";
    }
}

function nextSong() {
    try{
        if(shuffle){
            playShuffledSong();
        }
        document.getElementsByClassName("song")[lastIndex+1].click();
    }catch (e) {
        console.error(e);
    }
}

function previousSong() {
    try{
        if(shuffle){
            document.getElementsByClassName("song")[alreadyPlayedSongs[alreadyPlayedSongs.length-1]].click();
        }
        document.getElementsByClassName("song")[lastIndex-1].click();
    }catch (e) {
        console.error(e);
    }
}

var alreadyPlayedSongs=[];
var shuffle=false;
function startstopShuffle() {
    if(shuffle){
        shuffle=false;
        document.getElementById("shuffleButton_SongPlayer").style.backgroundColor="buttonface";
    }else{
        shuffle=true;
        document.getElementById("shuffleButton_SongPlayer").style.backgroundColor="green";
    }
    alreadyPlayedSongs=[];
}

function playShuffledSong() {
    const songs = document.getElementsByClassName("song");
    if(alreadyPlayedSongs.length!=songs.length){
        document.getElementsByClassName("song")[shuffleSong(songs.length)].click();
    }
}

function shuffleSong(len) {
    const index = getRandomNumber(0,len-1);
    if(alreadyPlayedSongs.includes(index)){
       return shuffleSong(len);
    }
    return index;
}

function getRandomNumber(start,stop) {
    return Math.floor(Math.random() * stop) + start;
}
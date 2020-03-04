import youtube_dl
import sys
import time
import urllib.parse as urlparse
from urllib.parse import parse_qs

parsed = urlparse.urlparse(sys.argv[1])
id=parse_qs(parsed.query)['v']

filename1 = str(round(time.time()))+'_'+id[0]
ydl_opts = {
    'format': 'bestaudio/best',
	'outtmpl': '../../data/songs/'+filename1+'.%(ext)s',
	'quiet':'True',
    'postprocessors': [{
        'key': 'FFmpegExtractAudio',
        'preferredcodec': 'mp3',
        'preferredquality': '192',
    }],
}


if __name__ == "__main__":
    with youtube_dl.YoutubeDL(ydl_opts) as ydl:
        filename = sys.argv[1:]
        ydl.download(filename)
        print(filename1+'.mp3')
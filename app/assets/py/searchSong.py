import sys
import json
from youtube_search import YoutubeSearch

searchString = sys.argv[1]
limit = int(sys.argv[2])
offset = int(sys.argv[3])

#print("searchString:"+searchString)
#print("limit:"+str(limit))
#print("offset:"+str(offset))

resultsStr = YoutubeSearch(searchString, max_results=limit).to_json()
resultsJson = json.loads(resultsStr)
#print(resultsJson)
#output='{"songs":['
output=""
for i in range(offset):
    del resultsJson['videos'][0]

#for i in range(len(resultsJson)):
 #   del resultsJson['videos'][i]['id']

c=0 
for i in resultsJson["videos"]:
	idsplit = i["id"].split("&")
	linksplit = i["link"].split("&")
	if c==0:
		output=output+'{"id":"0","title":"'+i["title"].replace('"',"").replace("'","")+'","filename":"0","url":"https://youtube.com'+linksplit[0]+'","image":"https://img.youtube.com/vi/'+idsplit[0]+'/0.jpg"}'
	else:
		output=output+',{"id":"0","title":"'+i["title"].replace('"',"").replace("'","")+'","filename":"0","url":"https://youtube.com'+linksplit[0]+'","image":"https://img.youtube.com/vi/'+idsplit[0]+'/0.jpg"}'
	c=c+1
#output=output+']}'
print(output)
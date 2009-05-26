#!/usr/bin/env python2.5
import urllib2,os,os.path
import sys

def main() :
	if( len(sys.argv) > 1 ):
		url = sys.argv[1]
		outputdir = ''
		if( len(sys.argv) > 2):
			outputdir = sys.argv[2]
			
		resultname = youtubefetch(url,outputdir)
		if(resultname == "failed"):
			print "Failed to get: " + url
		else:
			print "Got:" + resultname
			
	else:
		print "Usage: scraper.py youtubeurl [outputdir] ."

def youtubefetch(url,outputp=''):
	""" youtubefetch(url[,outputpath])
	Fetches youtube flvs when given a link, and will store them in /tmp/
	or in the specficied directory, and returns a path to the stored file."""
	outputpath = os.path.expanduser(outputp)
	if (os.path.exists(outputpath) & os.path.isdir(outputpath)) != True:
		outputpath = '/tmp/'
	
	(_,_,urlproper) = url.partition("?")
	(urlproper,_,_) = urlproper.partition("&")
	urlproper = "http://proxy.cs.tcd.ie:8080/www.youtube.com/watch?" + urlproper
	page = urllib2.urlopen(url).readlines()
	filteredpage = [ elem for elem in page if elem.find("fullscreenUrl") != -1 ]
	if (len(filteredpage) == 0):
		return 'failed'
		
	filteredpage = filteredpage[0]
	(_, p1, partialurl) = filteredpage.partition("video_id=")
	(partialurl , _, name) = partialurl.rpartition("&title=")
	(name,_,_) = name.partition("'")
	videourl = "http://www.youtube.com/get_video.php?" + p1 + partialurl
	video = urllib2.urlopen(videourl).read()
	#print videourl
	#print name
	outputfile = open((outputpath+name+".flv"),'wb')
	outputfile.write(video)
	outputfile.flush()
	outputfile.close()
	return outputpath+name+".flv"
	
if __name__ == "__main__":
    main()

	
	
	

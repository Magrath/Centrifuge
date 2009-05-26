#!/usr/bin/env python
import centrifuge.crawler as crawler
import centrifuge.identify as identify
import centrifuge.db as db
import sys
import os
import os.path

from optparse import OptionParser
import centrifuge.screenc as screenc

def main() :
	"""Main function.
	Takes parameters root, uid, type, and webroot
		Root - Directory containing the media that needs to be added to the database.
		Uid - User ID that the media belongs to.
		Type - video type, whether it's a clip, tv show or movie.
		Webroot - Base url for the file when being served up by apache.
	"""
	parser = OptionParser()
	parser.add_option("-r","--root", action="store", type="string",dest="start")
	parser.add_option("-u","--uid", action="store", type="int",dest="uid")
	parser.add_option("-t","--type",action="store", type="string",dest="type")
	parser.add_option("-w","--webroot", action="store", type="string", dest="webroot")
	(options, args) = parser.parse_args()
	
	if((options.start == None) | (not(os.path.exists(options.start)))):
		sys.exit("Bad path for oot")

	if((options.webroot == None)):
		sys.exit("Bad path for webroot")

	if((options.type in ["clip","movie","tv"]) == False):
		print "Type not one of [clip, movie, tv]"

	if((options.uid == None) | (options.uid < 0)):
		sys.exit("Bad UID")

	result = crawler.crawlWithFilter(options.start,[".mp3",".avi"]);
	
	realFileRoot = str.replace(options.start, "\\\\", "\\")
	
	sqltoken = db.getSQLToken()
	for item in result:
		if(countExistence(sqltoken, item) == 0):
			
			# get a list of subfolders encapsulating the file
			splitfolders = item.split(os.sep)
			
			# name - filename of the current item, path stripped off
			filename = splitfolders[-1]
			
			# standardise delimiters
			filename = filename.replace(" ", ".")
			filename = filename.replace("_", ".")
			
			# name - strip off the .xxx extension and split into list
			filename = filename.split(".")[0:len(filename.split("."))-1]
			
			# generate the web location for the current item
			itemWebroot = str.replace(item, realFileRoot,options.webroot)
			itemWebroot = str.replace(itemWebroot, "\\", "/")
			
			# generate file title
			title = ""
			for i in filename:
				title = title + " " + i
			# handle hachoir exceptions
			try:
				fileinfo =  identify.ident(item)
			except:
				db.logError(sql, "Empty or malformed file:" + item, options.uid)
				continue
			
			# file is a video clip
			if (fileinfo[-1] == "video"):
				videoid = db.InsertVideo(sqltoken, item, title, options.uid, fileinfo, itemWebroot)
				videolength = fileinfo[3] * 20
				
				#def screencap(file, lengthsecs, screencapcount, outputdir):
				#print item
				screenc.screencap(item, videolength, os.getcwd()  + os.sep + "screenshots" + os.sep ,str(videoid))
				# if its a video clip
			
				if(options.type == "clip"):
					db.InsertVideoClip(sqltoken,videoid, "")
					
				elif(options.type == "tv"):
#					print splitfolders

					# generate TV show name
					# if parent folder starts with "season" - name according to next folder up
					# else, name according to parent folder
					parentFolder = splitfolders[len(splitfolders)-1]
					
					if(parentFolder.startswith("Season") or parentFolder.startswith("season")):
						showName = parentFolder
					else:
						showName = splitfolders[len(splitfolders)-2]

#					print showName
					
					db.InsertVideoTV(sqltoken, videoid, showName, "-", "-")
					
				elif(options.type == "movie"):
					db.InsertVideoMovie(sqltoken, videoid, "", 0, 0)
			
			# file is an audio clip
			elif(fileinfo[-1] == "audio"):
				db.InsertAudio(sqltoken,i, fileinfo)

			# file is an image
			elif(fileinfo[-1] == "image"):
				db.InsertImage(sqltoken,i, fileinfo)
			
			
	db.deleteSQLToken(sqltoken)
	
def countExistence(sql, filename):
	exists = 0
	for i in ["audio", "video", "image"]:
		exists += db.CountExistence(sql, filename, i)
	return exists

# take in a list
#def getName(filename)


# flattens a multi dimensional list
def flatten(x):
    result = []
    for el in x:
        #if isinstance(el, (list, tuple)):
        if hasattr(el, "__iter__") and not isinstance(el, basestring):
            result.extend(flatten(el))
        else:
            result.append(el)
    return result
	
	

if __name__ == "__main__":
	main()



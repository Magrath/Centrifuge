import subprocess
import os.path
import os
import time

def screencap(file, lengthsecs, screencapcount, outputdir):
	if os.path.exists(file) and os.path.isdir(outputdir):
		ofile = os.path.abspath(outputdir) + os.sep + file
	# ffmpeg -itsoffset -$SECOFFSET -i $INPUTFILE -vcodec png -vframes 1 -an -f rawvideo $OUTPUTFILE.$NUMBER.png
		(_,_,filename) = file.rpartition("/")
		devnull = open("/dev/null",'w')
		commandargs1 = " -itsoffset -"
		commandargs2 = " -i " + file + " -vcodec png -vframes 1 -an -f rawvideo " + filename
		count = 1
		
		t = lengthsecs / screencapcount
		while count < (screencapcount):
			subprocess.Popen("ffmpeg " + commandargs1 + str(count * t) + commandargs2 + "." + str(count) + ".png" ,stderr=devnull,stdout=None,stdin=None,shell=True)
			#time.sleep(2)
			count += 1
		
		return 0
	
	return 1
	
def screencap_test(file, framecount, screencapcount):
	if os.path.exists(file):
		stream = pyffmpeg.VideoStream()
		stream.open(file)
		imageList = []
		count = 1
		while count < framecount:
			imageList.append(stream.GetFrameNo(count))
			count += framecount / screencapcount
		
		count = 0
		for i in imageList:
			i.save('screencap' + str(count) + '.png')
			count += 1
		
		return
	
	return []
	

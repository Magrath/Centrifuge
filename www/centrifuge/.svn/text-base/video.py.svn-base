#!/usr/bin/env python

import hachoir_parser
import hachoir_core.cmd_line
import sys
from hachoir_metadata.safe import fault_tolerant, getValue
import datetime

def ParseVideo(filename):
    """ THIS IS ALL SORTS OF BULLSHIT"""

    
    TAG_TO_KEY = {
        "INAM": "title",
        "IART": "artist",
        "ICMT": "comment",
        "ICOP": "copyright",
        "IENG": "author", 
        "ISFT": "producer",
        "ICRD": "creation_date",
        "IDIT": "creation_date",
        }
    
    unifile = hachoir_core.cmd_line.unicodeFilename(filename)
    parser = hachoir_parser.createParser(unifile)

    try:
        #print "Type:", parser["type"].value
        
        if "avi_hdr" in parser["headers"]:
            r = useAviHeader(parser["headers"]["avi_hdr"])
            return r

        for i in parser["info"]:
            if "tag" in i:
                if i["tag"].value == "LIST":
                    for j in i:
                        print "?", i["text"].value
                        print "?", i["tag"].value
                        print "?", TAG_TO_KEY[i["tag"].value]

                print "!", i["text"].value
                print "!", i["tag"].value
                print "!", TAG_TO_KEY[i["tag"].value]
    except hachoir_core.field.field.MissingField:
        pass

    return ["Fail", None, None, None, None, None]

def useAviHeader(header):
    microsec = header["microsec_per_frame"].value

    # Return format for all video:
    # type, frame rate, frames, duration, width, height
    
    results = ["AVI", None, None, None, None, None]
    if microsec:
        results[1] = (1000000.0 / microsec)
      #  print "Frame rate: ", results[1]
        results[2] = getValue(header, "total_frame")
       # print "Total frames: ",  results[2]
        #if total_frame and not self.has("duration"):
        results[3] = results[2] // results[1] + 1
	#datetime.timedelta(microseconds=results[1] * microsec)
        #print "duration: ", results[3]
        results[4] =  header["width"].value
        #print "Width: ", results[4]
        results[5] =  header["height"].value
        #print "Height: ", results[5]

    return results

def main():
    
    filename = sys.argv[1]
    datas = ParseVideo(filename)
    for i in datas:
        if i: 
            print i

if __name__ == "__main__":
    
    print "This really should be called as a module by MediaServ..."
    main()

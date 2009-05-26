#!/usr/bin/env python

from PIL import Image
import imghdr

def ParseImage(filename):
    
    returnarray = [None for i in range(0,5)]
    
    try:
        im = Image.open(filename)
    except IOError:
        print "failed to identify", file
    else:
        #print "image format: %s" % im.format
        returnarray[0] = im.format
        
        #print "image mode: %s" % im.mode
        returnarray[1] = im.mode
        
        #print "image size: ", im.size
        returnarray[2] = im.size
        
        if im.info.has_key("description"):
            returnarray[3] = im.info["description"]

        print im.info

    returnarray[4] = imghdr.what(filename)

    return returnarray

def main():
    filename = sys.argv[1]
    datas = ParseImage(filename)
    for i in datas:
        if i: 
            print i



if __name__ == "__music__":
    print "This really should be called as a module by MediaServ..."
    main()

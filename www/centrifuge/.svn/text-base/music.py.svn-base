#!/usr/bin/env python

import eyeD3
import sys

def ParseMusic(filename, doimage=False):
    tag = eyeD3.Tag()
    tag.link(filename)

    returnarray = [None for i in range(0,14)]
    returnarray[0] = tag.getArtist()
    returnarray[1] = tag.getAlbum()
    returnarray[2] = tag.getBPM()
    returnarray[3] = tag.getCDID()
    returnarray[4] = tag.getComments()[0].description
    returnarray[5] = tag.getDate()[0].date_str
    returnarray[6] = tag.getDiscNum()
    returnarray[7] = tag.getGenre()
    returnarray[8] = tag.getLyrics()
    returnarray[9] = tag.getPlayCount()
    returnarray[10] = tag.getPublisher()
    returnarray[11] = tag.getTitle()
    returnarray[12] = tag.getTrackNum()
    returnarray[13] = tag.getURLs()

    try:
        if tag.getImages()[0] and doimage:
            tag.getImages()[0].writeFile(".", "test.png")
    except IndexError:
        print "No album art"

    return returnarray

def main():
    
    filename = sys.argv[1]
    datas = ParseMusic(filename)
    for i in datas:
        if i: 
            print i

if __name__ == "__main__":
    
    print "This really should be called as a module by MediaServ..."
    main()

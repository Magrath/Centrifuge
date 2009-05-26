#!/usr/bin/env python
# Media identification and shit
# Hugh Nowlan <nosmo@netsoc.tcd.ie>

import mimetypes
import hachoir_parser
import hachoir_core.cmd_line
import sys

# Package imports
from centrifuge import general
from centrifuge import music
from centrifuge import image
from centrifuge import video

"""File Identifier for Centrifuge.

 This file imports the parsers and uses them as is needed based on filetype.
 I am not docstring-ing all of these fucking functions.

  VideoParse: for parsing video files
  MetadataFilter: for general file parsing using hacoir
   (May not remain)
  MusicParse: parses id3 tags
  ImageParse: parses images
  GeneralInfo: stuff from os.stat etc

"""

__author__ = "nosmo@netsoc.tcd.ie (Hugh Nowlan)"

def VideoParse(filename, filetype=None):
    
    results = []
    results = video.ParseVideo(filename)#, filetype)

    return results

def MetadataFilter(parser):
    try:
        metadata = hachoir_metadata.extractMetadata(parser)
    except:
        metadata = None

    return metadata

def MusicParse(filename):
    results = music.ParseMusic(filename)
    return results

def ImageParse(filename):
    results = image.ParseImage(filename)
    return results

def GeneralInfo(filename):
    results = general.ParseGeneral(filename)
    return results

def main() :

    filename = sys.argv[1]
    
    results = ident(filename)
    
    for i in results:
        if i:
            print i

def ident(filename) :
    
    mimetypes.init()
    filetype = mimetypes.guess_type(filename)[0]

    unifile = hachoir_core.cmd_line.unicodeFilename(filename)
    parser = hachoir_parser.createParser(unifile)
    meta = MetadataFilter(parser)

    #if meta:
    #    print meta

    generalinfo = GeneralInfo(filename)
    results = None
    #print filetype
    if filetype.startswith("video"):
        results = VideoParse(filename, filetype) + ["video"]
        if not results[0] == "Fail":
            results[0] = filetype
        
    elif filetype.startswith("audio"):
        results = MusicParse(filename) + ["audio"]
        
    elif filetype.startswith("image"):
        results = ImageParse(filename) + ["image"]

    #print generalinfo

    return results


if __name__ == "__main__":
    main()

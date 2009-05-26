#!/usr/bin/env python

import os
import time


def ParseGeneral(filename):
    
    filestat = os.stat(filename)

    #print "Size: %dKB" % (os.path.getsize(filename) / 1024)
    #print "UID/GID: %d / %d" % (filestat[5], filestat[6])
    #print "file modified:", time.asctime(time.localtime(filestat[9]))

    return ((os.path.getsize(filename) / 1024), filestat[5], filestat[6], time.asctime(time.localtime(filestat[9])))

def main():
    
    filename = sys.argv[1]
    datas = ParseGeneral(filename)
    for i in datas:
        if i: 
            print i

if __name__ == "__main__":
    
    print "This really should be called as a module by MediaServ..."
    main()

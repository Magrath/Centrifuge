#!/usr/bin/env python

import video
import MySQLdb

"""Centrifuge database insertion logic

 Inserts video information into the SQL database for presentation via
 the web interface.

"""

__author__ = "nosmo@netsoc.tcd.ie"

def CountExistence(sql, filepath, table):
	key = table + "id"
	sql.execute("select %s from %s where filepath = \"%s\"" % (key, table, filepath))
	count = len( sql.fetchall())
	return count

def InsertVideo(sql, filepath, title, uid,videodata,webpath):
    """Insert values into the VIDEO table in the DB.

    Args:
     filepath: What do you think?

    Returns:
     videoid: an integer that contains the videoid assigned to the new file
    """
    
    if title == None:
        # This is stupid and so are you
        title = filename.split("/")[-1]
    filename = filepath.split("/")[-1]
    sql.execute('insert into video (format, filepath, videotitle, length, height, width, uploaded_by, webpath) values("%s", "%s", "%s", %s, %s, %s, %s, "%s") ' %
                (videodata[0], filepath, title, videodata[3], videodata[5], videodata[4], uid, webpath))
    sql.execute('select videoid from video where filepath = "%s"' % filepath)
    videoid = int( sql.fetchall()[0][0] )
    return videoid


def InsertImage(sql, filepath, uid, imageinfo):
    """Insert values into the IMAGE table in the DB.

    Args:
     sql - sql cursor
     filepath: What do you think?
     imageinfo - List of image parameters that we've obtained.

    Returns:
     Nothing.
    """
    
    
    sql.execute("insert into image (height, width, filepath, format, uploaded_by) values(%s, %s, \"%s\", \"%s\", %s) " %
                (imageinfo[0], filepath, title, imageinfo[3], imageinfo[4], imageinfo[5], uid))

    return
    
def InsertAudio(sql, filepath, uid, audioinfo):
	""" Insert values into the AUDIO table in the DB. 
	"""
	
	(_,_,format) = filepath.rpartition(".")
	
	sql.execute("insert into audio (title, artist, album, tracknumber, tracktitle, filepath, format, uploaded_by) values(\"%s\", \"%s\", \"%s\", %s , \"%s\", \"%s\", \"%s\", %s) " %
			(audioinfo[11], audioinfo[0], audioinfo[2], audioinfo[12], audioinfo[11], filepath, format,uid))
	return

def InsertVideoTV(sql, videoid, showname, season, epno):
    """Insert a TV video

    Args:
     sql: MySQLdb cursor object
     videoid: video id from Insert Video
     showname: string containing the name of the show (supplied by web interface)
     season: integer containing the show's season (web interface)
     epno: integer containing the show's current iteration (web interface)

    Returns:
     nothing
    """

    sql.execute("insert into video_tv (videoid, tvshow, season, episodenumber) values(%d, \"%s\", \"%s\", \"%s\")" %
                (videoid, showname, season, epno))

def InsertVideoMovie(sql, videoid, director, imdbid, imdbrating):
    """Insert a TV video

    Args:
     sql: MySQLdb cursor object
     videoid: video id from Insert Video
     director: String containing the film's director's name (web interface)
     imdbid: integer containing the corresponding IMDB film ID (?)
     imdbrating: integer containing the average rating given by the users of IMDB (?)

    Returns:
     nothing
    """

    sql.execute("insert into video_movies (videoid, director, imdbid, imdbrating) values(%d, \"%s\", %d, %d)" %
                ( videoid, director, imdbid, imdbrating))

def InsertVideoClip(sql, videoid, source):
    """Insert a TV video

    Args:
     sql: MySQLdb cursor object
     videoid: video id from Insert Video
     source: a string containing what the user claims is the source (web interface)

    Returns:
     nothing
    """

    sql.execute("insert into video_clips (videoid, clipsource) values(%d, \"%s\")" % (videoid, source))

def main():
    # These are all temporary values, pass them in later
    uid = 666
    title = "Weapons of Ass Destruction II"
    filename = "/Users/nosmo/Movies/152611.avi"
    showname = "Dirty porn"
    director = "Adolf Spitzer"
    season = 2
    ep = 1
    imdbid = 0
    imdbrating = 0
    source = "http://mediaserv.on.nimp.org"
    videotype = 0
    
    connection = MySQLdb.Connect(host="127.0.0.1", port=3306, user="root", passwd="^hsaFTYfvtsa%", db="centrifuge")
    cursor = connection.cursor()

    videoid = InsertVideo(cursor, filename, title, uid)

    if videotype == 0:
        InsertVideoTV(cursor, videoid, showname, season, ep)
    elif videotype == 1:
        InsertVideoMovie(cursor, videoid, director, imdbid, imdbrating)
    elif videotype == 2:
        InsertVideoClip(cursor, videoid, source)

    cursor.close()
        
if __name__ == "__main__":
    main()

def getSQLToken():
    connection = MySQLdb.Connect(host="127.0.0.1", port=3306, user="mediaserv", passwd="mediaservpass123", db="mediaserv")
    cursor = connection.cursor()
    return cursor
    
def deleteSQLToken(cursor):
    cursor.close()

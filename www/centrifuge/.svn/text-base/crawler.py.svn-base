#!/usr/bin/env python
# Crawler module:
# v2 Simon - 18/Feb/2008
# v3 Paul - 23/Feb/2008
# Provides functionality to produce lists given a directory.

import os
import os.path
			
def crawl(root):
	"""crawl(Root) when Root is a valid path, ending in a directory.
	Returns a list of all files that exist beneath that root, including
	those in the directory `Root`.
	If Root isn't a valid path, it will fail silently, returning the empty
	list.
	Supports ~ and ~user constructions."""
	if ((root != None) & (os.path.exists(root))):
		root = os.path.expanduser(root);
		""" Sanitize the valid input path, needs to have a '/' on the end
			or else the files comprehension will fail."""
		if ( root.endswith(os.sep)):
			newroot = os.path.abspath(root) + os.sep
		else:
			newroot = os.path.abspath(root) + os.sep
		#print root + os.sep
		#newroot = root
		List = os.listdir(newroot)
		
		files = [ newroot + elem for elem in List if os.path.isfile(newroot + elem) ]
		dirs = [ newroot + elem for elem in List if os.path.isdir(newroot + elem) ]
		
		for i in dirs:
			files = files + crawl(i)
		
		return files
	else:
		return []
	
def crawlWithFilter(root, ExtWantedList):
	"""crawlWithFilter(Root, ExtWantedList) when Root is a valid path, ending in a directory ,
	ExtWantedList is a list of extensions that the file wanted have. 
	
	Extensions should include the '.' otherwise it may match a supplied extension as a partial 
	part of a file's extensions, causing the file to be wrongly included."""
	List = crawl(root)
	NewList = [ elem for elem in List if filter(elem, ExtWantedList) ]
	return NewList
		
		
		
def filter(TString, ExtWantedList):
	"""filter(TString, ExtWantedList) where TString is valid string, ExtWantedList is a valid list of strings

	Tests each element of ExtWantedList against TString to see if it's a suffix of TString, returns on first match."""
	for i in ExtWantedList:
		if ( TString.endswith(i)):
			return True
	
	return False

def main() :
	print "No."; 

if __name__ == "__main__":
	main()

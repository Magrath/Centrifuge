#!/usr/bin/env python
  #-*- coding: UTF-8 -*-

import ruya

def test():
    url= 'http://istec.colostate.edu/me/facil/dynamics/avis.htm'

     # Create a Document instance representing start url
    doc= ruya.Document(ruya.Uri(url))
    
     # Create a logger.
    log= ruya.Config.LogConfig();
    
     # Create a new crawler configuration object
    cfg= ruya.Config(ruya.Config.CrawlConfig(levels= 1, crawldelay= 5), ruya.Config.RedirectConfig(), log)
    
     # Use a single-domain breadth crawler with crawler configuration
    c= ruya.SingleDomainDelayCrawler(cfg)
    
     # Crawler raises following events before crawling a url.
     # Setup callbacks pointing to custom methods where we can control whether to crawl or ignore a url e.g. to ignore duplicates?
    c.bind('beforecrawl', beforecrawl, None)
    c.bind('aftercrawl', aftercrawl, None)
    c.bind('includelink', includelink, None)
    
     # Start crawling
    c.crawl(doc)
    
     #
    if(None!= doc.error):
        print(`doc.error.type`+ ': '+ `doc.error.value`)

  # This callback is invoked from Ruya crawler before a url is to be included in list of urls to be crawled
  # We can choose to ignore the url based on our custom logic
def includelink(caller, eventargs):
     uri= eventargs.uri
     level= eventargs.level
     print 'includelink(): Include "%(uri)s" to crawl on level %(level)d?' %locals()

  # Before a url is actually crawled, Ruya invokes this callback to ask whether to crawl the url or not.
  # We can choose to ignore the url based on our custom logic
def beforecrawl(caller, eventargs):
     uri= eventargs.document.uri
     print 'beforecrawl(): "%(uri)s" is about to be crawled...' %locals()

  # After a url is crawled, Ruya invokes this callback where we can check crawled values of a url.
def aftercrawl(caller, eventargs):
     doc= eventargs.document
     uri= doc.uri

     print 'Url: '+ uri.url
     print 'Title: '+ doc.title
     print 'Description: '+ doc.description
     print 'Keywords: '+ doc.keywords
     print 'Last-modified: '+ doc.lastmodified
     print 'Etag: '+ doc.etag
    
     # Check if any errors occurred during crawl of this url
     if(None!= doc.error):
         print 'Error: '+ `doc.error.type`
         print 'Value: '+ `doc.error.value`

     print 'aftercrawl(): "%(uri)s" has finished crawling...' %locals()

if('__main__'== __name__):
     # Test Ruya crawler
     test()

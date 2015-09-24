import os, datetime
from scrapy.exceptions import DropItem

class ItemError():

    """To save the error into an errorlog"""
    def __init__(self, msg, spidername, url):
        filename = '/home/ubuntu/dealscrape/error_logs/'+spidername+'.log'
        WRITENEW_MODE = 'w+b'
        WRITEAPPEND_MODE = 'a+b'
        statinfo = os.stat(filename)
        if int(statinfo.st_size) > 100000:
            mode = WRITENEW_MODE
        else:
            mode = WRITEAPPEND_MODE
        time = datetime.datetime.now().__str__()
        with open(filename, mode) as f:
            f.write(time + ' : ' + url + '\n')
            f.write('\t' + msg + '\n')
        DropItem(msg)

class ItemError_NoExcept():

    """To save the error into an errorlog"""
    def __init__(self, msg, spidername, url):
        filename = '/home/ubuntu/dealscrape/error_logs/'+spidername+'.log'
        WRITENEW_MODE = 'w+b'
        WRITEAPPEND_MODE = 'a+b'
        statinfo = os.stat(filename)
        if int(statinfo.st_size) > 100000:
            mode = WRITENEW_MODE
        else:
            mode = WRITEAPPEND_MODE
        time = datetime.datetime.now().__str__()
        with open(filename, mode) as f:
            f.write(time + ' : ' + url + '\n')
            f.write('\t' + msg + '\n')
        
            
        
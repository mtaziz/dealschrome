from scrapy.xlib.pydispatch import dispatcher
from scrapy import signals
from scrapy.exceptions import DropItem
from dealscrape.exceptions import ItemError
from urlparse import urlparse

class DuplicatesPipeline(object):
    def __init__(self):
        dispatcher.connect(self.spider_opened, signals.spider_opened)

    def spider_opened(self, spider):
        """
        add a data structure to save all the crawled items
        to use along the pipelines
        """
        spider.crawled_items = {}

    def process_item(self, item, spider):
        print '\n\n\n\n',item.get('url',None),'\n\n\n\n'
        key = item.get('title', None)
        url = item.get('url', None)
        if not key:
            raise ItemError(
                "Missing title in remove duplicate pipeline: "+repr(item),
                spider.name, url)
        if not url:
            raise ItemError(
                "Missing url in remove duplicate pipeline"+repr(item),
                spider.name, url)
        if key in spider.crawled_items:
            if len(url) > len(spider.crawled_items[key]['url']):
                spider.crawled_items[key] = item
            raise ItemError("Duplicate item found: %s" % item,spider.name, url)
        else:
            spider.crawled_items[key] = item
            return item
            

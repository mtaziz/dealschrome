from scrapy.xlib.pydispatch import dispatcher
from scrapy import signals
import solr as solrpy

"""\
spider starts:
    delete all where site is dealsource
spider ends:
    add new items
    commit
"""

class SolrPipeline(object):

    search_engine = 'http://122.248.241.145:8080/dealschrome/search-engine'
    archive = 'http://122.248.241.145:8080/dealschrome/archive'

    def __init__(self):
        dispatcher.connect(self.spider_opened, signals.spider_opened)
        dispatcher.connect(self.spider_closed, signals.spider_closed)
        self.search_engines = {}
        self.archives = {}

    def spider_opened(self, spider):
        self.search_engines[spider] = solrpy.SolrConnection(self.search_engine)
        self.archives[spider] = solrpy.SolrConnection(self.archive)
        self.search_engines[spider].delete_query('dealsource:'+spider.name)

    def spider_closed(self, spider):
        engine = self.search_engines.pop(spider)
        arch = self.archives.pop(spider)
        for k,v in spider.crawled_items.items():
            engine.add(
                id = v['url'],
                title = v['title'],
                dealsource = spider.name,
                category_raw = v['category'],
                price = str(v['price']),
                discount = str(v['discount']),
                bought = str(v['bought']),
                imgsrc = v['imgsrc'],
                expiry = str(v['expiry']),
                merchant = v['merchant'],
            )
            arch.add(
                id = v['url'],
                title = v['title'],
                dealsource = spider.name,
                category_raw = v['category'],
                price = str(v['price']),
                discount = str(v['discount']),
                bought = str(v['bought']),
                imgsrc = v['imgsrc'],
                expiry = str(v['expiry']),
                merchant = v['merchant'],
            )
        engine.commit()
        arch.commit()
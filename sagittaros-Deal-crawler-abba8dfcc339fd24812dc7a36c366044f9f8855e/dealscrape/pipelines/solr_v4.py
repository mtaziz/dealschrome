from scrapy.xlib.pydispatch import dispatcher
from scrapy import signals
from sunburnt import SolrInterface
from time import time
from dealscrape import endpoints
import types

"""
v3:
solr is pushed to the top of pipeline
it now provide the olddeals in the form of dict{url:created} to spider.olddeals,\
it is used by categorize.py to identify old deals and hence avoid overwriting 
the category

v4:
delete the old deals after adding documents, not before
"""


class SolrPipeline(object):

    search_engine = endpoints.solr + '/dealschrome/search-engine'
    archive = endpoints.solr + '/dealschrome/archive'

    def __init__(self):
        dispatcher.connect(self.spider_opened, signals.spider_opened)
        dispatcher.connect(self.spider_closed, signals.spider_closed)
        self.si_eng = SolrInterface(self.search_engine)
        self.si_eng.init_schema()
        self.si_arc = SolrInterface(self.archive)
        self.si_arc.init_schema()
        self.old_deals = {}

    def spider_opened(self, spider):
        source = spider.allowed_domains[0]
        old_temp = self.get_old_deals(source)
        self.old_deals[spider] = {i['id']:i for i in old_temp}
        spider.old_deals = dict(self.old_deals[spider])

    def spider_closed(self, spider):
        source = spider.allowed_domains[0]
        old_deals = self.old_deals.pop(spider)
        
        if spider.crawled_items.items():        
            for k,v in spider.crawled_items.items():
                if old_deals.has_key(v['url']):
                    field_created = old_deals[v['url']]['created']
                    del old_deals[v['url']]
                else:
                    field_created = int(time())
                    
                data = {
                    'id' : v['url'],
                    'title' : v['title'],
                    'dealsource' : source,
                    'price' : str(v['price']),
                    'worth' : str(v['worth']),
                    'discount' : str(v['discount']),
                    'bought' : str(v['bought']),
                    'imgsrc' : v['imgsrc'],
                    'category' : v['category'],
                    'created' : field_created,
                    'expiry' : str(v['expiry']),
                    'merchant' : v['merchant'],
                    'address' : v['address'],
                    'description': v['description'],
                }
                if v['location']:
                    # only add location when location exists
                    data['location'] = v['location']
                
                # its a BUG,this code is to correct multiple valued category
                if len(data['category']) > 1 and not isinstance(data['category'], types.StringTypes):
                    data['category'] = data['category'][0]
                            
                self.si_eng.add(data)
                self.si_arc.add(data)
            
            self.si_eng.commit()
            self.si_arc.commit()
            
            pending_delete = [doc for doc in old_deals.itervalues()]
            if pending_delete:
                self.si_eng.delete(pending_delete)
            
            self.si_eng.commit()
            self.si_arc.commit()
    
    def get_old_deals(self, source):
        old_deals = self.si_eng\
            .query(dealsource_raw=source)\
            .field_limit(['id','created','category_raw'],score=False)\
            .paginate(rows=900)\
            .execute()
        return old_deals        
        
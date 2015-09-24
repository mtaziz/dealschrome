from scrapy.xlib.pydispatch import dispatcher
from scrapy import signals
from scrapy import log
import time
import MySQLdb
import MySQLdb.cursors

"""\

PIPELINE SCHEME

when spider open:
    find spider/dealsource id, if not exists, create one first
    mark all state as grey : (0=expired, 1=active, 2=grey state)
when spider close:
    for all crawled items:
        update or insert accordingly
    mark all grey state to expired
    
    
"""

class SQLStorePipeline(object):

    unpublished_state = 0
    published_state = 1
    grey_state = 2

    def __init__(self):
        dispatcher.connect(self.spider_opened, signals.spider_opened)
        dispatcher.connect(self.spider_closed, signals.spider_closed)
        self.conn = {}
        self.cursor = {}
        self.dealsource_id = {}
        
    def spider_opened(self, spider):
        self.conn[spider] = MySQLdb.connect(
            host='122.248.241.145',
            db='play',
            user='play', 
            passwd='WINDzen89', 
            cursorclass=MySQLdb.cursors.DictCursor,
            charset='utf8', use_unicode=True
        )
        self.cursor[spider] = self.conn[spider].cursor()
        self.mark_all_as_grey(spider)
        
    def spider_closed(self, spider):
        self.conditional_insert(spider)
        self.unpublish_grey_items(spider)
        self.cursor[spider].close()
        self.conn[spider].commit()
        self.conn[spider].close()
    
    def mark_all_as_grey(self, spider):
        if self._get_dealsource_id(spider):
            self.cursor[spider].execute(
                "update tbl_deal set status=%s where dealsource_id=%s and status=%s",
                (self.grey_state, self.dealsource_id[spider], self.published_state))
        else:
            # new deals coming, no need to set deals to grey
            self._insert_dealsource(spider)
            self._get_dealsource_id(spider)            
    
    def unpublish_grey_items(self, spider):
        if not self.dealsource_id[spider]:
            # cannot reach spider closed without having spider opened run the greystate marking
            log.msg('updating non-existent site items', level=log.ERROR)
            raise
        self.cursor[spider].execute(
            "update tbl_deal set status=%s where status=%s and dealsource_id=%s",
            (self.unpublished_state, self.grey_state, self.dealsource_id[spider]))
    
    def conditional_insert(self, spider):
        for key,item in spider.crawled_items.items():
            # create record if doesn't exist. 
            self.cursor[spider].execute(
                "select * from tbl_deal where url = %s and status <> %s", 
                (item['url'], self.unpublished_state))
            result = self.cursor[spider].fetchone()
            if result:
                self._update_deal(item, spider)
            else:
                self._insert_deal(item, spider)
            
    def _get_dealsource_id(self, spider):
        self.cursor[spider].execute(
            "select id from tbl_dealsource where name = %s", 
            (spider.name,))
        result = self.cursor[spider].fetchone()
        
        if not result:
            # insert the new dealsource
            self.cursor[spider].execute(\
            "insert into tbl_dealsource (domain, name) "
            "values (%s, %s)", 
            (spider.allowed_domains[0], spider.name))
            
            # get the id of the newly inserted dealsource
            result = self.cursor[spider].execute(
            "select id from tbl_dealsource where name = %s", 
            (spider.name,))
            
        self.dealsource_id[spider] = result['id']
        return self.dealsource_id[spider]
            
    def _update_deal(self, item, spider):
        self.cursor[spider].execute(\
            "update tbl_deal set " 
            "status=%s, title=%s, bought=%s, price=%s, discount=%s, imgsrc=%s, expiry=%s, created=%s "
            "where url=%s and status<>%s",
            (
                self.published_state,
                item['title'],
                item['bought'],
                item['price'],
                item['discount'],
                item['imgsrc'],
                item['expiry'],
                int(time.time()),
                item['url'],
                self.unpublished_state
            ))
        log.msg("Item updated: %s" % item, level=log.INFO)
        return True
    
    def _insert_deal(self, item, spider):
        self.cursor[spider].execute(\
            "insert into tbl_deal (dealsource_id, url, title, bought, price, discount, imgsrc, expiry, created, status) "
            "values (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
            (
                self.dealsource_id[spider],
                item['url'],
                item['title'],
                item['bought'],
                item['price'],
                item['discount'],
                item['imgsrc'],
                item['expiry'],
                int(time.time()),
                self.published_state
            ))
        log.msg("Item added: %s" % item, level=log.INFO)
        return True
    
    
    def handle_error(self, e):
        log.msg("Error in mysql pipeline: %s" % e, level=log.CRITICAL)
from scrapy.contrib.linkextractors.sgml import SgmlLinkExtractor
from scrapy.contrib.spiders import CrawlSpider, Rule
from dealscrape.utils import data_extractor,data_processor
from dealscrape.utils import location_resolver
from dealscrape.utils import description_resolver
import time,re
from dealscrape.exceptions import ItemError, ItemError_NoExcept

class Spider(CrawlSpider):
    name = 'juztoday_com'
    allowed_domains = ['juztoday.com']
    
    # a listing of directories where all the deals can be found
    start_urls = [
        'http://juztoday.com',
    ]
    
    allowlist = (r'/deal\.php')
    denylist = ()
    restrict_xpathslist = ("//div[@class='right intro']/a[1]")
    
    rules = ( Rule ( SgmlLinkExtractor(
        allow=allowlist,deny=denylist,restrict_xpaths=restrict_xpathslist), 
        callback='parse_item', follow=False),)

    def extract_latlng(spider,hxs,response):
        return location_resolver.extract_from_url(
            "//iframe/@src",'ll',
            spider,hxs,response)
    
    def extract_expiry(spider,hxs,response):
        scripts = data_extractor.extractXpath(hxs,"//script",None,'')
        index = re.findall("(?<=var countdown = )\d+(?=;)",scripts)
        try:
            ret = time.time() + int(index[0])
        except:
            ret = ""
        return ret   
    
    getters = {
        'title' : ("//h1/div[@class='viewer']//text()",None),
        'imgsrc' : ("//img[@class='main']/@src",0),
        'price' : ("//span[@class='price']//text()",None),
        'bought' : ("//div[@class='bought-count']/div[2]//text()",None),
        'discount' : None,
        'merchant' : ("//div[@id='partner']//font/b//text()",None),
        'worth' : ("//div[@class='price left']//text()",None),
        'description' : ("//div[@class='quote']//text()",None),
        'location' : extract_latlng,
        'expiry' : extract_expiry,
    }
    
    def parse_item(self, response):
        data = data_extractor.extractItems(self, response, self.getters)
        try:
            print '\n\n\n\n\n',repr(data),'\n\n\n\n'
            worth = data_processor.extract_decimals(data['worth'])
            price = data_processor.extract_decimals(data['price'])
            savings = worth - price
            data['discount'] = (savings/worth)*100
        except:
            data['discount'] = None
        return data


        
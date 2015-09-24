from scrapy.contrib.linkextractors.sgml import SgmlLinkExtractor
from scrapy.contrib.spiders import CrawlSpider, Rule
from dealscrape.utils import data_extractor
from dealscrape.utils import location_resolver
from dealscrape.utils import description_resolver
from dealscrape.utils import expiry_resolver
import time
from dealscrape.exceptions import ItemError, ItemError_NoExcept

class Spider(CrawlSpider):
    name = 'voucherlicious_com'
    allowed_domains = ['voucherlicious.com']
    
    # a listing of directories where all the deals can be found
    start_urls = [
        'http://voucherlicious.com',
    ]
    
    allowlist = ('/Singapore/deal')
    denylist = ()
    restrict_xpathslist = ("//h2[@class='title']/a")
    
    rules = ( Rule ( SgmlLinkExtractor(
        allow=allowlist,deny=denylist,restrict_xpaths=restrict_xpathslist), 
        callback='parse_item', follow=True),)

    def extract_latlng(spider,hxs,response):
        return location_resolver.extract_from_url(
            "//div[@class='map-block']/a/img/@src",'center',
            spider,hxs,response)
            
    def extract_description(spider,hxs,response):
        return description_resolver.extract_from_li(
            "//div[@class='highlight-block']//text()",
            spider,hxs,response)
    
    def extract_expiry(spider,hxs,response):
        secsLeft = data_extractor.extractNumericXpath(hxs,"//span[@class='js-time hide']//text()")
        print '\n\n\n\nsecs left: ',secsLeft,' current time: ',time.time()
        print '  expiry:: ',secsLeft+time.time(),'\n\n\n'
        return expiry_resolver.from_timeleft(secondsleft=secsLeft)
            
    getters = {
        'title' : ("//h2[@class='title']/text()",None),
        'imgsrc' : ("//div[@class='section2']/img/@src",0),
        'price' : ("//p[@class='price']/span[@class='c cr']//text()",None),
        'worth' : ("//dl[@class='deal-value clearfix']//text()",None),
        'bought' : ("//h3/span[@class='c']/text()",None),
        'discount' : ("//div[@class='save-block']/p//text()",None),
        'merchant' : ("//div[@class='map-info-left-block']/p[@class='big']//text()",None),
        'description' : extract_description,
        'location' : extract_latlng,
        'expiry' : extract_expiry,
    }
    
    def parse_item(self, response):
        return data_extractor.extractItems(self, response, self.getters)

            
        
from scrapy.contrib.linkextractors.sgml import SgmlLinkExtractor
from scrapy.contrib.spiders import CrawlSpider, Rule
from dealscrape.utils import data_extractor
from dealscrape.utils import location_resolver
from dealscrape.utils import description_resolver
from dealscrape.utils import expiry_resolver
from dealscrape.exceptions import ItemError, ItemError_NoExcept

class Spider(CrawlSpider):
    name = 'streetdeal_sg'
    allowed_domains = ['streetdeal.sg']
    
    # a listing of directories where all the deals can be found
    start_urls = [
        'http://www.streetdeal.sg/home',
    ]
    
    allowlist = (r'/deals/view')
    denylist = ()
    restrict_xpathslist = ("//div[@class='deal_headar']")
    
    rules = ( Rule ( SgmlLinkExtractor(
        allow=allowlist,deny=denylist,restrict_xpaths=restrict_xpathslist), 
        callback='parse_item', follow=False),)

    def extract_latlng(spider,hxs,response):
        return location_resolver.extract_from_address(
            "//div[@class='merchant_details']/p[1]//text()",
            spider,hxs,response)
    
    def extract_description(spider,hxs,response):
        return description_resolver.extract_from_li(
            "//div[@class='highlights']//li//text()",
            spider,hxs,response)
            
    def extract_expiry(spider,hxs,response):
        seconds = data_extractor.extractXpath(hxs,"//input[@name='deal_time_left']/@value",None);
        if seconds:
                return expiry_resolver.from_timeleft(secondsleft=int(seconds))

    getters = {
        'title' : ("//div[@class='deal_headar']//text()",None),
        'imgsrc' : ("//div[@class='deal_image']//@src",0),
        'price' : ("//div[@class='deal_price']//text()",None),
        'worth' : ("//div[@class='deal_value left']//text()",None),
        'bought' : ("//h4[@class='bought']//text()",None),
        'discount' : ("//div[@class='deal_discount left']//text()",None),
        'merchant' : ("//div[@class='merchant_details']/h5//text()",0),
        'location' : extract_latlng,
        'description': extract_description,
        'expiry' : extract_expiry
    }
    
    def parse_item(self, response):
        return data_extractor.extractItems(self, response, self.getters)

            
        
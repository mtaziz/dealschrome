from scrapy.contrib.linkextractors.sgml import SgmlLinkExtractor
from scrapy.contrib.spiders import CrawlSpider, Rule
from dealscrape.utils import data_extractor
from dealscrape.utils import location_resolver
from dealscrape.utils import description_resolver
import time
from dealscrape.exceptions import ItemError, ItemError_NoExcept

class Spider(CrawlSpider):
    name = 'groupon_sg'
    allowed_domains = ['groupon.sg']
    
    # a listing of directories where all the deals can be found
    start_urls = [
        'http://www.groupon.sg/deals/singapore',
        'http://www.groupon.sg/deals/visa',
        'http://www.groupon.sg/deals/deals-near-me',
        'http://www.groupon.sg/deals/travel-deals',
        'http://www.groupon.sg/deals/shopping',
    ]
    
    allowlist = (r'/deals')
    denylist = ()
    restrict_xpathslist = ("//div[@class='extraDealDescription']//a")
    
    rules = ( Rule ( SgmlLinkExtractor(
        allow=allowlist,deny=denylist,restrict_xpaths=restrict_xpathslist), 
        callback='parse_item', follow=True),)

    def extract_latlng(spider,hxs,response):
        return location_resolver.extract_from_url(
            "//div[@class='googleMap jGoogleMap']/img/@src",'center',
            spider,hxs,response)
            
    def extract_description(spider,hxs,response):
        return description_resolver.extract_from_li(
            "//div[@class='viewHalfWidthSize'][1]/ul/li//text()",
            spider,hxs,response)
    
    def extract_expiry(spider,hxs,response):
        timeleft = data_extractor.extractNumericXpath(hxs,"//input[@id='currentTimeLeft']/@value")
        now = time.time()
        return timeleft/1000 + now
        
    def extract_worth(spider,hxs,response):
        return data_extractor.extractNumericXpath(hxs,"//table[@class='savings']//td[2]//text()") +\
        data_extractor.extractNumericXpath(hxs,"//span[@class='price']//text()")
            
    getters = {
        'title' : ("//div[@id='contentDealTitle']/h1/a//text()",0),
        'imgsrc' : ("//form[@id='buyTheDealBig']/button[@class='nobg']/img/@src",0),
        'price' : ("//span[@class='price']//text()",None),
        'bought' : ("//span[@id='jDealSoldAmount']//text()",None),
        'discount' : ("//table//td//text()",None),
        'merchant' : ("//div[@class='merchantContact']/h2[@class='subHeadline']//text()",0),
        'worth' : extract_worth,
        'description' : extract_description,
        'location' : extract_latlng,
        'expiry' : extract_expiry,
    }
    
    def parse_item(self, response):
        return data_extractor.extractItems(self, response, self.getters)

            
        
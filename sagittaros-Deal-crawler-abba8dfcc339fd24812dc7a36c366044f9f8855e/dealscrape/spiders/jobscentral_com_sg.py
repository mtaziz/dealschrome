from scrapy.contrib.linkextractors.sgml import SgmlLinkExtractor
from scrapy.contrib.spiders import CrawlSpider, Rule
from dealscrape.utils import data_extractor
from dealscrape.utils import location_resolver
from dealscrape.utils import description_resolver
from dealscrape.utils import expiry_resolver
import time
from dealscrape.exceptions import ItemError, ItemError_NoExcept

class Spider(CrawlSpider):
    name = 'jobscentral_com_sg'
    allowed_domains = ['jobscentral.com.sg']
    
    # a listing of directories where all the deals can be found
    start_urls = [
        'http://jobscentral.com.sg/learningdeals',
    ]
    
    allowlist = (r'/deal')
    denylist = ()
    restrict_xpathslist = ("//div[@id='sideDeals']/a")
    
    rules = ( Rule ( SgmlLinkExtractor(
        allow=allowlist,deny=denylist,restrict_xpaths=restrict_xpathslist), 
        callback='parse_item', follow=True),)
            
    def extract_description(spider,hxs,response):
        return description_resolver.extract_from_li(
            "//div[@id='provider']//text()",
            spider,hxs,response)
    
    def extract_expiry(spider,hxs,response):
        timestring = data_extractor.extractXpath(hxs,"//span[@id='origEnd']/@name")
        timeleft = int(expiry_resolver.from_timestring(timestring)) - 8*3600
        return timeleft
        
    getters = {
        'title' : ("//span[@id='theTitle']//text()",None),
        'imgsrc' : ("//div[@class='dsl']/img/@src",0),
        'price' : ("//div[@id='pay']//text()",None),
        'bought' : None,
        'discount' : ("//table[@class='paytabletext']//td[2]/text()",None),
        'merchant' : None,
        'worth' : ("//table[@class='paytabletext']//td[1]/text()",None),
        'description' : extract_description,
        'location' : None,
        'expiry' : extract_expiry,
    }
    
    def parse_item(self, response):
        return data_extractor.extractItems(self, response, self.getters)

            
        
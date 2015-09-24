from scrapy.contrib.linkextractors.sgml import SgmlLinkExtractor
from scrapy.contrib.spiders import CrawlSpider, Rule
from dealscrape.utils import data_extractor
from dealscrape.utils import location_resolver
from dealscrape.utils import description_resolver
from dealscrape.utils import expiry_resolver
from dealscrape.exceptions import ItemError, ItemError_NoExcept
import re

class Spider(CrawlSpider):
    name = 'superdeals_insing_com'
    allowed_domains = ['superdeals.insing.com']
    
    # a listing of directories where all the deals can be found
    start_urls = [
        'http://superdeals.insing.com/',
    ]
    
    allowlist = (r'.com/deal')
    denylist = ()
    restrict_xpathslist = ()
    
    rules = ( Rule ( SgmlLinkExtractor(
        allow=allowlist,deny=denylist,restrict_xpaths=restrict_xpathslist), 
        callback='parse_item', follow=False),)
        
    def extract_description(spider,hxs,response):
        return description_resolver.extract_from_li(
            "//div[@class='detailInfo']/p//text()",
            spider,hxs,response)
            
    def extract_expiry(spider,hxs,response):
        script = data_extractor.extractXpath(hxs,"//script",None);
        if script:
            timeleft = int(re.findall("(?<=\.countdown\(\{until: \'\+)\d+",script)[0])
            if timeleft:
                return expiry_resolver.from_timeleft(secondsleft=int(timeleft))
        
    """
    getters is a dict of either
        tuple of (xpath, index),
        function to extract the field
    """
    getters = {
        'title' : ("//li[@class='lastDeal']/h1[@class='title']/text()",None),
        'imgsrc' : ("//div[@class='dealImage slider-wrapper']//img[1]/@src",0),
        'price' : ("//div[@class='price']/dl/dd/strong/text()",None),
        'worth' : ("//dl[@class='value']/dd/strong/text()",None),
        'bought' : ("//p[@class='soldCountText']/text()",None),
        'discount' : ("//h1[@class='title']/strong/text()",0),
        'merchant' : None,
        'location' : None,
        'description' : extract_description,
        'expiry' : extract_expiry,
    }
    
    def parse_item(self, response):
        return data_extractor.extractItems(self, response, self.getters)

            
        
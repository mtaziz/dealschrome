from scrapy.contrib.linkextractors.sgml import SgmlLinkExtractor
from scrapy.contrib.spiders import CrawlSpider, Rule
from dealscrape.utils import data_extractor
from dealscrape.utils import location_resolver
from dealscrape.utils import description_resolver
import time
from dealscrape.exceptions import ItemError, ItemError_NoExcept

class Spider(CrawlSpider):
    name = 'nicedeal_sg'
    allowed_domains = ['nicedeal.sg']
    
    # a listing of directories where all the deals can be found
    start_urls = [
        'http://nicedeal.sg',
    ]
    
    allowlist = (r'/deal')
    denylist = ()
    restrict_xpathslist = ("//a[@class='multi-title']")
    
    rules = ( Rule ( SgmlLinkExtractor(
        allow=allowlist,deny=denylist,restrict_xpaths=restrict_xpathslist), 
        callback='parse_item', follow=False),)

    def extract_latlng(spider,hxs,response):
        return location_resolver.extract_from_url(
            "//iframe/@src",'ll',
            spider,hxs,response)
            
    def extract_description(spider,hxs,response):
        return description_resolver.extract_from_li(
            "//div[@class='digest']//text()",
            spider,hxs,response)
    
    def extract_expiry(spider,hxs,response):
        curtime = data_extractor.extractNumericXpath(hxs,"//div[@id='deal-timeleft']/@curtime")
        timeleft = data_extractor.extractNumericXpath(hxs,"//div[@id='deal-timeleft']/@diff")
        return (curtime+timeleft)/1000
        
    def extract_worth(spider,hxs,response):
        return data_extractor.extractNumericXpath(hxs,"//table[@class='savings']//td[2]//text()") +\
        data_extractor.extractNumericXpath(hxs,"//span[@class='price']//text()")
            
    getters = {
        'title' : ("//h1/a[@class='multi-title']//text()",None),
        'imgsrc' : ("//div[@id='team_images']//img/@src",0),
        'price' : ("//span[@id='deal_price']//text()",None),
        'bought' : ("//span[@class='deal-buy-tip-top']//text()",None),
        'discount' : ("//p[@id='discount']//text()",None),
        'merchant' : ("//h3[@id='partner_name']//text()",None),
        'worth' : ("//p[@id='market_price']//text()",None),
        'description' : extract_description,
        'location' : extract_latlng,
        'expiry' : extract_expiry,
    }
    
    def parse_item(self, response):
        return data_extractor.extractItems(self, response, self.getters)

            
        
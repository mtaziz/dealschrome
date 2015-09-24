from scrapy.contrib.linkextractors.sgml import SgmlLinkExtractor
from scrapy.contrib.spiders import CrawlSpider, Rule
from dealscrape.utils import data_extractor
from dealscrape.utils import location_resolver
from dealscrape.utils import description_resolver
from dealscrape.utils import expiry_resolver
import time
from dealscrape.exceptions import ItemError, ItemError_NoExcept

class Spider(CrawlSpider):
    name = 'shiokdeal_com'
    allowed_domains = ['shiokdeal.com']
    
    # a listing of directories where all the deals can be found
    start_urls = [
        'http://www.shiokdeal.com',
    ]
    
    allowlist = ('/team.php\?id=')
    denylist = ()
    restrict_xpathslist = ("//div[@class='sbox-content']/div[@class='tip']//a")
    
    rules = ( Rule ( SgmlLinkExtractor(
        allow=allowlist,deny=denylist,restrict_xpaths=restrict_xpathslist), 
        callback='parse_item', follow=True),)

    def extract_latlng(spider,hxs,response):
        return location_resolver.extract_from_url(
            "//div[@id='side-business']//iframe/@src",'ll',
            spider,hxs,response)
            
    def extract_description(spider,hxs,response):
        return description_resolver.extract_from_li(
            "//div[@class='digest']/text()",
            spider,hxs,response)
    
    def extract_expiry(spider,hxs,response):
        hours = "//div[@class='limitdate']//li[1]/span//text()"
        minutes = "//div[@class='limitdate']//li[2]/span//text()"
        return expiry_resolver.from_livetimer(hxs,hours,minutes)
        
    def extract_worth(spider,hxs,response):
        return data_extractor.extractNumericXpath(hxs,"//table[@class='savings']//td[2]//text()") +\
        data_extractor.extractNumericXpath(hxs,"//span[@class='price']//text()")
            
    getters = {
        'title' : ("//div[@id='deal-intro']/h1/text()",0),
        'imgsrc' : ("//div[@id='team_images']//img/@src",0),
        'price' : ("//p[@class='deal-price']//text()",None),
        'worth' : ("//table[@class='deal-discount']//td[1]/text()",None),
        'bought' : ("//p[@class='deal-buy-tip-top']//text()",None),
        'discount' : ("//table[@class='deal-discount']//td[2]/text()",None),
        'merchant' : ("//div[@id='side-business']/h2/text()",0),
        'description' : extract_description,
        'location' : extract_latlng,
        'expiry' : extract_expiry,
    }
    
    def parse_item(self, response):
        return data_extractor.extractItems(self, response, self.getters)

            
        
from scrapy.contrib.linkextractors.sgml import SgmlLinkExtractor
from scrapy.contrib.spiders import CrawlSpider, Rule
from dealscrape.utils import data_extractor
from dealscrape.utils import location_resolver
from dealscrape.utils import description_resolver
from dealscrape.utils import expiry_resolver
import re,time
from dealscrape.exceptions import ItemError, ItemError_NoExcept

class Spider(CrawlSpider):
    name = 'swoop_com_sg'
    allowed_domains = ['swoop.com.sg']
    
    # a listing of directories where all the deals can be found
    start_urls = [
        'http://swoop.com.sg',
    ]
    
    allowlist = ('/deals/')
    denylist = ('/purchase')
    restrict_xpathslist = ('//section//h1//a')
    
    rules = ( Rule ( SgmlLinkExtractor(
        allow=allowlist,deny=denylist,restrict_xpaths=restrict_xpathslist), 
        callback='parse_item', follow=False),)

    def extract_latlng(spider,hxs,response):
        return location_resolver.extract_from_url(
            "//div[@id='deal-gmaps']/small/a/@href",'ll',
            spider,hxs,response)
            
    def extract_description(spider,hxs,response):
        return description_resolver.extract_from_li(
            "//div[@id='deal-highlights']/ul/li//text()",
            spider,hxs,response)
    
    def extract_expiry(spider,hxs,response):
        return time.time() + 86400
            
    getters = {
        'title' : ("//head/meta[@property='og:title']/@content",None),
        'imgsrc' : ("//div[@class='deal_images_wrap']//img/@src",0),
        'price' : ("//div[@class='deal-price']//text()",None),
        'worth' : ("//div[@class='deal-price-retail']//text()",None),
        'bought' : None,
        'discount' : ("//div[@class='deal-discount']//text()",None),
        'merchant' : ("//div[@id='deal-contact-info-content']/p[1]/b//text()",None),
        'description' : extract_description,
        'location' : extract_latlng,
        'expiry' : extract_expiry,
    }
    
    def parse_item(self, response):
        return data_extractor.extractItems(self, response, self.getters)

            
        
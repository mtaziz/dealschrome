from scrapy.contrib.linkextractors.sgml import SgmlLinkExtractor
from scrapy.contrib.spiders import CrawlSpider, Rule
from dealscrape.utils import data_extractor
from dealscrape.utils import location_resolver
from dealscrape.utils import description_resolver
from dealscrape.utils import expiry_resolver
import re
from dealscrape.exceptions import ItemError, ItemError_NoExcept

class Spider(CrawlSpider):
    name = 'deal_com_sg'
    allowed_domains = ['deal.com.sg']
    
    # a listing of directories where all the deals can be found
    start_urls = [
        "http://deal.com.sg/deals/singapore",
    ]
    
    entrylinks = ()
    entryxpaths = ("//li[@class='pager-item']")
    
    allowlist = (r'/deals/singapore')
    dealxpaths = ("//div[@class='deal-content']//div[@id='deal-title']")
    
    rules = ( 
        Rule ( 
        SgmlLinkExtractor( allow=entrylinks,restrict_xpaths=entryxpaths,canonicalize=False),
        follow=True
        ),
        
        Rule ( 
        SgmlLinkExtractor(allow=allowlist,restrict_xpaths=dealxpaths,canonicalize=False), 
        callback='parse_item',
        follow=False
        ),
    )
    
    def extract_latlng(spider,hxs,response):
        return location_resolver.extract_from_address(
            "//div[@class='today-deal-partner']/p[3]//text()",
            spider,hxs,response)
    
    def extract_description(spider,hxs,response):
        return description_resolver.extract_from_li(
            "//span[@class='today-deal-high']/ul/li//text()",
            spider,hxs,response)
    
    def extract_expiry(spider,hxs,response):
        scripts = data_extractor.extractXpath(hxs,"//script",None);
        if scripts:
            timeleft = int(re.findall('(?<=time_left":)\d+',scripts)[0]) / 1000
            if timeleft:
                return expiry_resolver.from_timeleft(secondsleft=int(timeleft))
            
    getters = {
        'title' : ('//div[@class="today-deal-title"]/text()',None),
        'imgsrc' : ('//div[@class="today-deal-img"]/div[1]/img/@src',None),
        'price' : ("//div[@id='deal-price-sell']//text()",None),
        'worth' : ("//span[@id='deal-price-orig']//text()",None),
        'bought' : ('//div[@id="slider-count"]/div/text()',None),
        'discount' : ('//div[@id="deal-discount-bubble"]/div[1]/span[2]/text()',None),
        'merchant' : ('//div[@class="today-deal-partner"]/p[1]/strong/text()',None),
        'location' : extract_latlng,
        'description' : extract_description,
        'expiry' : extract_expiry,
    }
    
    def parse_item(self, response):
        return data_extractor.extractItems(self, response, self.getters)

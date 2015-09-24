from scrapy.contrib.linkextractors.sgml import SgmlLinkExtractor
from scrapy.contrib.spiders import CrawlSpider, Rule
from dealscrape.utils import data_extractor
from dealscrape.utils import location_resolver
from dealscrape.utils import description_resolver
from dealscrape.utils import expiry_resolver
from dealscrape.exceptions import ItemError, ItemError_NoExcept

class Spider(CrawlSpider):
    name = 'alldealsasia_com'
    allowed_domains = ['alldealsasia.com']
    
    # a listing of directories where all the deals can be found
    start_urls = [
        'http://www.alldealsasia.com/best-deals/singapore',
    ]
    
    allowlist = (r'/deals')
    denylist = ()
    restrict_xpathslist = ("//div[@class='d-title']")
    
    rules = ( Rule ( SgmlLinkExtractor(
        allow=allowlist,deny=denylist,restrict_xpaths=restrict_xpathslist), 
        callback='parse_item', follow=False),)

    def extract_latlng(spider,hxs,response):
        return location_resolver.extract_from_address(
            "//div[@class='d-about-text']/p//text()",
            spider,hxs,response)
            
    def extract_description(spider,hxs,response):
        return description_resolver.extract_from_li(
            "//div[@class='field field-type-text field-field-highlights']//li//text()",
            spider,hxs,response)
            
    def extract_expiry(spider,hxs,response):
        time = data_extractor.extractXpath(hxs,"//span[@class='datetime']//text()",0)
        print '\n\n\n',time,'\n\n\n' 
        try:
            ret = int(expiry_resolver.from_timestring(time))
        except:
            ret = ""
        return ret
        
    def extract_worth(spider,hxs,response):
        price = data_extractor.extractNumericXpath(hxs,"//div[@class='d-price-value']/text()")
        savings = data_extractor.extractNumericXpath(hxs,"//div[@class='d-discount-price']//text()")
        return price + savings
        
    getters = {
        'title' : ("//div[@class='ds-title']/h1/text()",0),
        'imgsrc' : ('//div[@class="d-cycle"]/img[1]/@src',0),
        'price' : ('//div[@class="d-price-value"]/text()',0),
        'worth' : extract_worth,
        'bought' : ("//div[@class='d-purchased']//text()",0),
        'discount' : ("//div[@class='d-save-cent']/text()",0),
        'merchant' : ('//div[@class="d-about-text"]/p//strong/text()',0),
        'location' : extract_latlng,
        'description':extract_description,
        'expiry' : extract_expiry,
    }
    
    def parse_item(self, response):
        return data_extractor.extractItems(self, response, self.getters)

            
        
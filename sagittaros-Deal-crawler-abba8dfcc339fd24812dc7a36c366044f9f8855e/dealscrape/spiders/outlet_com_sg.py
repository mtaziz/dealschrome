from scrapy.contrib.linkextractors.sgml import SgmlLinkExtractor
from scrapy.contrib.spiders import CrawlSpider, Rule
from dealscrape.utils import data_extractor
from dealscrape.utils import location_resolver
from dealscrape.utils import description_resolver
from dealscrape.utils import expiry_resolver
from dealscrape.exceptions import ItemError, ItemError_NoExcept

class Spider(CrawlSpider):
    name = 'outlet_com_sg'
    allowed_domains = ['outlet.com.sg']
    
    # a listing of directories where all the deals can be found
    start_urls = [
        'http://www.outlet.com.sg',
    ]
    
    allowlist = (r'/thedeal/view')
    denylist = ()
    restrict_xpathslist = (
        "//div[@class='leftbody']//div[@class='bd-titles']",
        "//div[@class='ctn-md']")
    
    rules = ( Rule ( SgmlLinkExtractor(
        allow=allowlist,deny=denylist,restrict_xpaths=restrict_xpathslist), 
        callback='parse_item', follow=False),)

    def extract_latlng(spider,hxs,response):
        return location_resolver.extract_from_address(
            "//div[@class='comp-moredeal']/*[not(self::p/strong|self::h3)]//text()",
            spider,hxs,response)
            
    def extract_description(spider,hxs,response):
        return description_resolver.extract_from_li(
            "//div[@class='highlights-boxmoredeal']//li//text()",
            spider,hxs,response)
            
    def extract_expiry(spider,hxs,response):
        scripts = data_extractor.extractXpath(hxs,"//script",None,'')
        index = scripts.find("jam1.TargetDate")
        if index:
            timestring = scripts[index+20:index+45]
            print '\n\n\nindex:scripts...{',index,'}\n\n\n{',timestring,'}\n\n\n\n\n'
            try:
                ret = int(expiry_resolver.from_timestring(timestring)) - 8*3600
            except:
                ret = ""
            return ret
        else:
            return None            

    getters = {
        'title' : ("//head/title//text()",0),
        'imgsrc' : ('//div[@class="slide-boxmoredeal"]/img/@src',0),
        'price' : ('//div[@id="price-btnbuynow"]/span/text()',None),
        'worth' : ("//div[@id='value-moredeal']//text()",None),
        'bought' : ('//div[@class="bought-boxmoredeal"]/p/span/text()',None),
        'discount' : ('//div[@id="discount-moredeal"]/span/text()',None),
        'hours' : ('//div[@id="hours-moredeal"]/span[1]/text()',0),
        'minutes' : ('//div[@id="minutes-moredeal"]/span[1]/text()',0),
        'merchant' : ('//div[@class="comp-moredeal"]/p[1]/strong/text()',0),
        'location' : extract_latlng,
        'description' : extract_description,
        'expiry' : extract_expiry
    }
    
    def parse_item(self, response):
        return data_extractor.extractItems(self, response, self.getters)

            
        
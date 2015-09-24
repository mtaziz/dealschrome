from scrapy.contrib.linkextractors.sgml import SgmlLinkExtractor
from scrapy.contrib.spiders import CrawlSpider, Rule
from dealscrape.utils import data_extractor
from dealscrape.utils import location_resolver
from dealscrape.utils import description_resolver
from dealscrape.exceptions import ItemError, ItemError_NoExcept

class Spider(CrawlSpider):
    name = "dealcreation_com"
    allowed_domains = ["dealcreation.com"]
    
    # a listing of directories where all the deals can be found
    start_urls = [
        "http://www.dealcreation.com",
    ]

    allowlist = (r'/deal')
    denylist = ()
    restrict_xpathslist = ("//div[@id='porletmiddle']//div[@id='otherdealcontent']")
    
    rules = ( Rule ( SgmlLinkExtractor(
        allow=allowlist,deny=denylist,restrict_xpaths=restrict_xpathslist), 
        callback='parse_item', follow=False),)
                
    getters = {
        'title' : ('//div[@id="title"]/h1[1]/text()',None),
        'imgsrc' : ('//div[@class="coda-slider"]/div[1]/div[1]//img[1]/@src',None),
        'price' : ('//div[@id="dealrightbox"]/div[@id="innerboxtop"]//text()',None),
        'bought' : ('//div[@id="alreadysold"]//text()',None),
        'discount' : ('//div[@id="discount"]//text()',None),
        'hours' : ("//div[@class='dash hours_dash']/div[@class='digit']//text()",None),
        'minutes' : ("//div[@class='dash minutes_dash']/div[@class='digit']//text()",None),
        'merchant' : (),
        'location' : None
    }
    
    def parse_item(self, response):
        return data_extractor.extractItems(self, response, self.getters)

            
        
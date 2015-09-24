from scrapy.contrib.linkextractors.sgml import SgmlLinkExtractor
from scrapy.contrib.spiders import CrawlSpider, Rule
from dealscrape.utils import data_extractor
from dealscrape.utils import location_resolver
from dealscrape.utils import description_resolver
from dealscrape.exceptions import ItemError, ItemError_NoExcept

class Spider(CrawlSpider):
    name = 'plus_bigdeal_sg'
    allowed_domains = ['plus.bigdeal.sg']
    
    # a listing of directories where all the deals can be found
    start_urls = [
        "http://plus.bigdeal.sg/",
        "http://plus.bigdeal.sg/bazaar/",
        "http://plus.bigdeal.sg/meal/",
        "http://plus.bigdeal.sg/escape/",
        "http://plus.bigdeal.sg/fun/",
        "http://plus.bigdeal.sg/beauty/",
        "http://plus.bigdeal.sg/family/",
        "http://plus.bigdeal.sg/goods/"
    ]
    
    entrylinks = ()
    entryxpaths = ("//ul[@class='paginator']")
    
    allowlist = (r'.html')
    denylist = ()
    dealxpaths = (
        "//div[@class='title-align']",
        "//div[@id='sidebar']//div[@class='tip']",
        "//div[@class='title']"
    )
    
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
        return location_resolver.extract_from_url(
            "//div[@id='side-business']//iframe/@src",'ll',
            spider,hxs,response)
    
    def extract_description(spider,hxs,response):
        digest = description_resolver.extract_from_li(
            "//div[@class='digest']//text()",
            spider,hxs,response)
        highlights = description_resolver.extract_from_li(
            "//div[@class='blk detail']/p/text()",
            spider,hxs,response)
        return digest + highlights
    
    def extract_expiry(spider,hxs,response):
        curtime = data_extractor.extractNumericXpath(hxs,"//div[@class='deal-timeleft']/@curtime")
        diff = data_extractor.extractNumericXpath(hxs,"//div[@class='deal-timeleft']/@diff")
        return int((curtime + diff)/1000)
    
    def extract_title(spider,hxs,response):
        title = data_extractor.extractXpath(hxs,"//meta[@property='og:title']/@content")
        subtitle = data_extractor.extractXpath(hxs,"//div[@class='sub_title']//text()")
        return (title + ' ' + subtitle).strip()
    
    getters = {
        'title' : extract_title,
        'imgsrc' : ('//div[@id="team_images"]//li[1]/img[1]/@src',0),
        'price' : ('//div[@id="bigprice"]/text()',None),
        'worth' : ("//div[@id='priceinfo-value'][1]//text()",None),
        'bought' : ('//p[@class="deal-buy-tip-top"]/strong[1]/text() | //div[@id="deal-status"]//strong[1]/text()',None),
        'discount' : ('//div[@id="priceinfo"]/div[2]/div[1]/text()',None),
        'merchant' : ('//div[@id="side-business"]/h3[1]/text()',0),
        'location' : extract_latlng,
        'description' : extract_description,
        'expiry' : extract_expiry
    }
    
    def parse_item(self, response):
        return data_extractor.extractItems(self, response, self.getters)

            
        
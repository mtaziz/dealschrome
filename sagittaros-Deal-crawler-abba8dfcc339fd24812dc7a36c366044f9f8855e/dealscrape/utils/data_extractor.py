from scrapy.selector import HtmlXPathSelector
from dealscrape.items import DealscrapeItem
from dealscrape.utils import data_processor
from dealscrape.exceptions import ItemError_NoExcept
from types import FunctionType

    
def extractItems(spider, response, getters):
    """
    The real extraction is being done here
    :param getters: a dict of xpath tuple and functions
    """
            
    def extract(getter):
        if isinstance(getter, FunctionType):
            extracted = getter(spider,hxs,response)
        elif getter is None:
            extracted = ''
        else:
            xpath = getter[0]
            index = getter[1]
            truncatelimit = 255
            try:
                extracted = extractXpath(hxs,xpath,index).strip()[0:truncatelimit]                 
            except:
                ItemError_NoExcept('Extraction failed for XPath('+xpath+')', spider.name, response.url)
            if not extracted:
                ItemError_NoExcept('Extracted empty item from XPath('+xpath+')', spider.name, response.url)
        return extracted
    
    hxs = HtmlXPathSelector(response)
    i = DealscrapeItem()

    i['url'] = response.url
    i['title'] = extract(getters['title'])
    i['imgsrc'] = extract(getters['imgsrc'])
    i['price'] = extract(getters['price'])
    i['worth'] = extract(getters['worth'])
    i['bought'] = extract(getters['bought'])
    i['discount'] = extract(getters['discount'])
    i['expiry'] = extract(getters['expiry'])
    i['merchant'] = extract(getters['merchant'])
    i['description'] = extract(getters['description'])
    locationdata = extract(getters['location'])
    if locationdata is '':
        i['location'],i['original_source'],i['determined_source'],i['address'] = (None,None,None,None)
    else:
        i['location'],i['original_source'],i['determined_source'],i['address'] = locationdata
    return i

def extractNumericXpath(hxs,xpath,index=None):
    return data_processor.extract_decimals(extractXpath(hxs,xpath,index))

def extractXpath(hxs, xpath, index=0, delim=' '):
    extracted = hxs.select(xpath).extract()
    for i in range(len(extracted)):
        extracted[i] = extracted[i].strip()
    if index is not None and len(extracted)>index:
        return extracted[index].strip()
    else:
        return delim.join(extracted).strip()

def extractXpathArrays(hxs, xpath):
    return hxs.select(xpath).extract()
from dealscrape.exceptions import ItemError
from dealscrape.utils import data_processor
from urlparse import urlparse,urljoin
import re,time

class ValidatePipeline(object):

    def process_item(self, item, spider):
        # expiry is the most important thing to determine if a deal is active
        # it is therefore placed ahead of others so that exit asap when a deal is not active
        item = self.validate_expiry(item, spider)
        
        # because of shiokdeal
        #item = self.validate_url(item, spider)
        item = self.validate_title(item, spider)
        item = self.validate_imgsrc(item, spider)
        item = self.validate_price(item, spider)
        item = self.validate_worth(item, spider)
        item = self.validate_discount(item, spider)
        item = self.validate_bought(item, spider)
        item = self.validate_merchant(item, spider)
        item = self.validate_description(item, spider)
        item = self.validate_location(item, spider)
        item = self.validate_address(item, spider)
        return item
    
    def validate_expiry(self, item, spider):
        if item.get('expiry',None):
            item['expiry'] = int(item['expiry'])
            if item['expiry'] < time.time():
                raise ItemError("Deal expired, expired time = "+str(item['expiry'])+" ,current time = "+str(time.time()), spider.name, item['url'])
            else:
                return item
        else:
            raise ItemError("Unable to find expiry", spider.name, item['url'])
    
    def validate_url(self, item, spider):
        item['url'] = data_processor.reform_url(item['url'])
        return item
    
    def validate_title(self, item, spider):
        if item.get('title',None):
            item['title'] = item['title'].strip()
            if item['title']:
                return item
        # no title
        raise ItemError("Unable to find title", spider.name, item['url']);
            
    def validate_imgsrc(self, item, spider):
        if item.get('imgsrc',None):
            imgparts = urlparse(item['imgsrc'])
            urlparts = urlparse(item['url'])
            if imgparts[1]:
                head = imgparts[0]+'://'+imgparts[1]
            else:
                head = urlparts[0]+'://'+urlparts[1]
            item['imgsrc'] = urljoin(head, imgparts[2])
            return item
        else:
            raise ItemError("Unable to find imgsrc", spider.name, item['url'])
        
    def validate_price(self, item, spider):
        if item.get('price',None):
            item['price'] = data_processor.extract_decimals(item['price'])
            if not item['price']:
                item['price'] = 0
        else:
            item['price'] = 0 # free 
        return item
    
    def validate_worth(self, item, spider):
        if item.get('worth',None):
            item['worth'] = data_processor.extract_decimals(item['worth'])
            if not item['worth']:
                item['worth'] = 0
        else:
            item['worth'] = 0 # free 
        return item
            
    def validate_discount(self, item, spider):
        if item.get('discount',None):
            item['discount'] = data_processor.extract_decimals(item['discount'])
            if not item['discount']:
                item['discount'] = 0
            return item
        else:
            item['discount'] = 0
        return item
    
    def validate_bought(self, item, spider):
        if item.get('bought',None):
            try:
                item['bought'] = int(data_processor.extract_decimals(item['bought']))
            except:
                item['bought'] = 0
        else:
            item['bought'] = 0
        return item
        
    def validate_merchant(self,item, spider):
        if item.get('merchant',None):
            item['merchant'] = item['merchant'].strip()
            item['merchant'] = re.sub('[:%]','',item['merchant'])
        return item
    
    def validate_description(self, item, spider):
        if item.get('description', None):
            if item['description'] is '':
                item['description'] = 'Deal description is not available'
        return item
    
    def validate_location(self, item, spider):
        if not item.get('location',None):
            print 'Unable to find address'
        return item
        
    def validate_address(self, item, spider):
        if not item['address']:
            item['address'] = ''
        else:
            item['address'] = item['address'].strip()
        return item
        
        
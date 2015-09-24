# Define here the models for your scraped items
#
# See documentation in:
# http://doc.scrapy.org/topics/items.html

from scrapy.item import Item, Field

class DealscrapeItem(Item):
    url = Field()
    title = Field()
    imgsrc = Field()
    price = Field()
    worth = Field()
    discount = Field()
    bought = Field()
    expiry = Field()
    merchant = Field()
    address = Field()
    location = Field()
    original_source = Field()
    determined_source = Field()
    category = Field()
    dealsource = Field()
    description = Field()
    pass

from scrapy.xlib.pydispatch import dispatcher
from scrapy import signals
from scrapy.contrib.exporter import JsonItemExporter

class JSONExportPipeline(object):

    directory = '/home/ubuntu/dealscrape/output/'

    def __init__(self):
        dispatcher.connect(self.spider_opened, signals.spider_opened)
        dispatcher.connect(self.spider_closed, signals.spider_closed)
        self.files = {}

    def spider_opened(self, spider):
        file = open(self.directory + '%s_items.json' % spider.name, 'w+b')
        self.files[spider] = file
        self.exporter = JsonItemExporter(file)
        self.exporter.start_exporting()

    def spider_closed(self, spider):
        file = self.files.pop(spider)
        for k,v in spider.crawled_items.items():
            self.exporter.export_item(v)
        self.exporter.finish_exporting()
        file.close()
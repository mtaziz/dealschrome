# Scrapy settings for dealscrape project
#
# For simplicity, this file contains only the most important settings by
# default. All the other settings are documented here:
#
#     http://doc.scrapy.org/topics/settings.html
#

BOT_NAME = 'dealscrape'
BOT_VERSION = '1.0'

SPIDER_MODULES = ['dealscrape.spiders']
NEWSPIDER_MODULE = 'dealscrape.spiders'
USER_AGENT = '%s/%s' % (BOT_NAME, BOT_VERSION)

MEMUSAGE_NOTIFY_MAIL = ['felixsagitta@gmail.com','manutd8811@gmail.com']
MEMUSAGE_WARNING_MB = 450
TELNETCONSOLE_ENABLED = False

DOWNLOADER_MIDDLEWARES = {
    #'dealscrape.middlewares.WebkitDownloader.WebkitDownloader': 1000,
}

ITEM_PIPELINES = (
    'dealscrape.pipelines.solr_v4.SolrPipeline',
	'dealscrape.pipelines.validate.ValidatePipeline',
	'dealscrape.pipelines.categorize.CategorizePipeline',
	'dealscrape.pipelines.remove_duplicates.DuplicatesPipeline',
	'dealscrape.pipelines.json_export.JSONExportPipeline'
)

#LOG_FILE = '/home/ubuntu/dealscrape/log'
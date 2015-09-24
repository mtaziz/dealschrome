from dealscrape.utils import categorize
import solr
from dealscrape import endpoints

class CategorizePipeline(object):
    
    archive = endpoints.solr + '/dealschrome/archive'
    
    def __init__(self):
        self.conn = solr.SolrConnection(self.archive)
        
    def process_item(self, item, spider):
        response = self.conn.query('id:"'+item['url']+'"')
        if not response:
            item['category'] = categorize.determine_category(item['title']+' '+item['description'])
        else:
            item['category'] = response.results[0]['category_raw']
        return item
            

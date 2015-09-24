import solr
import re
from dealscrape import endpoints

def determine_category(input):
    catesolr = endpoints.solr + '/dealschrome/deal-category'
    s = solr.SolrConnection(catesolr)
    str = re.sub('[^a-zA-Z \'0-9]',' ',input)
    print '--------------------------------------\n'
    print str
    response = s.query(str,fields='id,score')
    if response:
        if response.results[0]['id'] == 'Services & Others' and len(response) > 1:
            return reduceServices(response)
        else:
            return response.results[0]['id']
    else:
        return 'Services & Others'

#first algo
def reduceServices(response):
    firstScore = response.results[0]['score']
    secondScore = response.results[1]['score']
    firstScore = firstScore / 2
    if firstScore > secondScore:
        print 'the category i determined is ', response.results[0]['id']
        print ' with score ', response.results[0]['score'], '\n'
        print 'vs category ', response.results[1]['id']
        print 'with score ', response.results[1]['score'], '\n'
        print 'reduced score of services and others is ', firstScore
        print '--------------------------------------\n'
        return response.results[0]['id']
    else:
        print 'the category i determined is ', response.results[1]['id']
        print ' with score ', response.results[1]['score'], '\n'
        print 'vs category ', response.results[0]['id']
        print 'with score ', response.results[0]['score'], '\n'
        print 'reduced score of services and others is ', firstScore
        print '--------------------------------------\n'
        return response.results[1]['id']

# second algo
def determineByDifference(response):
    firstScore = response.results[0]['score']
    secondScore = response.results[1]['score']
    diffPercentage = ((firstScore-secondScore)/firstScore) * 100
    if diffPercentage < 15:
        print '--------------------------------------\n'
        print 'for input ', str , '\n'
        print 'the category i determined is ', response.results[1]['id']
        print ' with score ', response.results[1]['score'], '\n'
        print 'vs category ', response.results[0]['id']
        print 'with score ', response.results[0]['score'], '\n'
        print 'the difference percentage is ', diffPercentage 
        print '--------------------------------------\n'
        return response.results[1]['id']
    else:
        print '--------------------------------------\n'
        print 'for input ', str , '\n'
        print 'the category i determined is ', response.results[0]['id']
        print ' with score ', response.results[0]['score'], '\n'
        print 'vs category ', response.results[1]['id']
        print 'with score ', response.results[1]['score'], '\n'
        print 'the difference percentage is ', diffPercentage 
        print '--------------------------------------\n'
        return response.results[0]['id']

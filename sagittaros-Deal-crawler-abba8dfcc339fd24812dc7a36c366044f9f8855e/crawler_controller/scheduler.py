import subprocess, shelve, os, math
from datetime import datetime
import viewstates

"""
Legend:
    db['spiders']: all the site that is being managed by this scheduler
    db['crawling']: the site that is being crawled
    db['running pid']: the process id of this scheduler
    db['runtime']: a dict to record the runtimes
"""

defaultspiders = {
    'groupon_sg' : 1,
    'alldealsasia_com' : 1,
    'plus_bigdeal_sg' : 1,
    'streetdeal_sg' : 1,
    'outlet_com_sg' : 1,
    'deal_com_sg' : 1,
    'superdeals_insing_com' : 1,
    'shiokdeal_com' : 1,
    'voucherlicious_com' : 1,
    'swoop_com_sg' : 1,
    'nicedeal_sg': 1,
    'juztoday_com': 1,
    'jobscentral_com_sg' :1,
}


def init_database(db,defaultspiders):
    if 'spiders' not in db:
        db['spiders'] = defaultspiders
        db['crawling'] = False
        db['running_pid'] = -1
        db['runtime'] = {}
        db.sync()

def is_crawler_idle(db):
    print 'the running process id is ',db['running_pid']
    if db['running_pid'] == -1:
        db['running_pid'] = os.getpid()
        return True
    else:
        if not os.path.exists('/proc/'+str(db['running_pid'])):
            print 'pid in database but not in /proc'
            db['running_pid'] = os.getpid()
            return True 
        else:
            print 'process found, wait for next turn'
            return False

def run_crawler(db):
    spider = get_spider(db)
    time_start = on_start_crawl(db,spider)
    logfile = '/home/ubuntu/dealscrape/spiderlogs/'+spider+'.log'
    os.chdir('/home/ubuntu/dealscrape')
    with open(logfile,'w+b') as f:
        subprocess.call(
            'scrapy crawl ' + spider, 
            stdout=f,
            shell=True
        )
    time_end = on_finished_crawl(db,spider)
    record_runtime(db,spider,time_start,time_end)
    db.close()

def on_start_crawl(db,spider):
    print 'starting to crawl ', spider, ' on ', repr(datetime.now())
    db['crawling'] = spider
    db.sync()
    viewstates.publishStates(db)
    return datetime.now()

def on_finished_crawl(db,spider):
    print 'finished crawling ', spider, ' on ', repr(datetime.now())
    db['crawling'] = False
    db['running_pid'] = -1
    db.sync()
    return datetime.now()

def record_runtime(db,spider,start,end):
    duration = (end-start).total_seconds()
    mins = duration / 60
    seconds = duration % 60
    timespent = repr(math.trunc(mins)) + 'mins ' + repr(math.trunc(seconds)) + 'seconds'
    if spider in db['runtime']:
        runtime = db['runtime'][spider]
        if duration > runtime['max_seconds']:
            runtime['max_seconds'] = duration
        if duration < runtime['min_seconds']:
            runtime['min_seconds'] = duration
    else:
        runtime = {'name':spider}
        runtime['max_seconds'] = duration
        runtime['min_seconds'] = duration
    runtime['timespent'] = timespent
    runtime['start'] = repr(start)
    runtime['end'] = repr(end)
    db['runtime'][spider] = runtime
    db.sync()
    viewstates.publishStates(db)
    

def get_spider(db):
    _increment_all_ranks(db)
    spider = _find_max(db)
    db['spiders'][spider] = 1
    db.sync()
    return spider

def _increment_all_ranks(db):
    for k in db['spiders'].iterkeys():
        db['spiders'][k] += 1
    
def _find_max(db):
    return max(db['spiders'].iterkeys(), key=lambda k: db['spiders'][k])

# main workflow
db = shelve.open('/home/ubuntu/dealscrape/crawler_controller/scheduler_states', writeback=True)
init_database(db,defaultspiders)
if is_crawler_idle(db):
    run_crawler(db)


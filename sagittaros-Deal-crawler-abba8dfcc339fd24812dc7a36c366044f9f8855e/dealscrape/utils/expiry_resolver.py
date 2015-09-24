import re,time,datetime
from dateutil import parser
from dealscrape.utils import data_extractor
from dealscrape.exceptions import ItemError_NoExcept
import data_extractor

def from_livetimer(hxs,hours,minutes):
    try:
        hours = int(data_extractor.extractNumericXpath(hxs,hours))
        mins = int(data_extractor.extractNumericXpath(hxs,minutes))
    except:
        hours = None
        mins = None
    return from_timeleft(hoursleft=hours,minutesleft=mins)


def from_timestring_format(string,format):
    return time.mktime(time.strptime(string,format))


def from_timestring(string):
    try:
        timestamp = parser.parse(string).strftime('%s')
    except:
        timestamp = None
    return timestamp
    
# return unix timestamp (since epoch time 1970)
def from_timeleft(daysleft=0, hoursleft=0, minutesleft=0, secondsleft=0):
    try:
        timediff = datetime.timedelta(days=daysleft, hours=hoursleft , minutes=minutesleft, seconds=secondsleft)
    except:
        return None
    secondsleft = timediff.total_seconds()
    expiry = secondsleft + time.time()
    rounded_expiry = round(expiry/60) * 60
    return rounded_expiry

import re
from urlparse import urlparse
from urlparse import parse_qs
from geopy import geocoders
from types import StringType
import re

def extract_decimals(string, index=0):
    string = str(string)
    m = re.search('\d+,?\d{0,3}\.?\d{0,2}', string)
    if m:
        return float(m.group(index).replace(',',''))
    else:
        return None
        
def reform_url(url):
    frags = urlparse(url)
    return frags[0] + '://' + frags[1] + frags[2] + frags[3]
    
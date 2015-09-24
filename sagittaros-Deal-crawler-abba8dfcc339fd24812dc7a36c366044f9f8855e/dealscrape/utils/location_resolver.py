from sunburnt import SolrInterface
from dealscrape import endpoints
from urlparse import urlparse
from urlparse import parse_qs
from geopy import geocoders
import re
from dealscrape.exceptions import ItemError_NoExcept
import data_extractor

"""
Different ways of extracting latlng
"""
def extract_from_address(xpath,spider,hxs,response,start=0,end=-1):
    original_source = None
    determined_source = None
    latlng = None
    address = ''
    _source = data_extractor.extractXpath(hxs,xpath,None,',')
    if end == -1:
        end = len(_source)
    original_source = _source[start:end] 
    if original_source:
        latlng,determined_source = _retrieve_address_from_history(original_source)
        if not latlng:
            try:
                latlng,determined_source = try_geocode_address(original_source)
            except:
                ItemError_NoExcept('Unable to geocode address('+repr(original_source)+')', spider.name, response.url)
        else:
            address = original_source
            return (latlng,original_source,determined_source,address)
    
    if original_source and latlng and determined_source:
        geodata = {
            'id': original_source,
            'latlng':latlng,
            'determined_source':determined_source
        }
        _add_address_to_history(geodata)
        address = original_source
    return (latlng,original_source,determined_source,address)

def extract_from_url(xpath,queryparam,spider,hxs,response):
    latlng = None
    address = ''
    url = data_extractor.extractXpath(hxs,xpath)
    if url:
        try:
            latlng = _geocode_url(url, queryparam)
            address = _reverse_geocode_address(latlng)
        except:
            pass
    else:
        url = 'Url xpath parse failed'
    return (latlng,url,url,address)

"""
Address geocode functions
"""
def try_geocode_address(address):
    parts = address.split(',')
    methods = [split_colon_address,permutate_address,permutate_address_bruteforce]
    geocoded = (None, None)
    for m in methods:
        if not geocoded[0]:
            geocoded = m(parts)
        else:
            break
    return geocoded

"""
this is used to find address inside an info box 
that also contains address,telephone,merchants details
"""
def split_colon_address(parts):
    geocoded = (None,None)
    for p in parts:
        if ':' in p:
            potential_address = p.split(':')[1]
            if _match_address(potential_address):
                geocoded = _geocode_address(potential_address)
                if geocoded[0]:
                    break
    return geocoded

def permutate_address(parts):
    geocoded = (None,None)
    for i in range(len(parts)):
        for k in range(i+1):
            if not geocoded[0]:
                potential_address = ','.join(parts[k:k+len(parts)-i])
                if _match_address(potential_address):
                    geocoded = _geocode_address(potential_address)
                    if geocoded[0]:
                        break
            else:
                break
    return geocoded

# same as above except dun care whether got postcode or not
def permutate_address_bruteforce(parts):
    geocoded = (None,None)
    for i in range(len(parts)):
        for k in range(i+1):
            if not geocoded[0]:
                potential_address = ','.join(parts[k:k+len(parts)-i])
                geocoded = _geocode_address(potential_address)
                if geocoded[0]:
                    break
            else:
                break
    return geocoded
    
"""
Internal utils
"""
def _match_address(potential_address):
    return re.search('\d{5}',potential_address)

def _geocode_address(address):
    g = geocoders.Google()
    try:
        (place,(lat,lng)) = g.geocode(address)
        ll = str(lat) + ',' +str(lng)
    except:
        place = None
        ll = None
    return (ll,place)
    
def _reverse_geocode_address(latlng):
    g = geocoders.Google()
    point = tuple(latlng.split(','))
    try:
        (address,newpoint) = g.reverse(point)
    except:
        address = ''
    return address

def _geocode_url(url, queryparam):
    try:
        parts = urlparse(url)
        qs = parts[4]
        ll = parse_qs(qs)[queryparam][0]        
    except:
        ll = None
    return ll

def _add_address_to_history(geodata):
    server = endpoints.solr + '/dealschrome/geodata'
    solr = SolrInterface(server)
    solr.add(geodata)
    solr.commit()

def _retrieve_address_from_history(original_source):
    server = endpoints.solr + '/dealschrome/geodata'
    solr = SolrInterface(server)
    res = solr.query(id=original_source).execute()
    if len(res):
        ll = str(res[0]['latlng'][0])+','+str(res[0]['latlng'][1])
        determined_source = res[0]['determined_source']
    else:
        ll = None
        determined_source = None
    return (ll,determined_source)
var map;
var mapBounds;
var mapCenter;
var mapRadius;
var markers = {};
var queriedTerms = {};
var coveredBounds = false;
var clickedMarker;
var userLocationMarker;
var userLat = 1.29991;
var userLng = 103.849426;

var controlvars = {
    'query': '*',
    'price': '*',
    'category_raw': '*',
    'discount': '*'
}

/**
 * Locks are to prevent racing condition
 */
var locks = new Object();

// reload_markers
locks.reload_markers = new Object();
locks.reload_markers.locked = false;
locks.reload_markers.isLocked = function(){
    return locks.reload_markers.locked;
}
locks.reload_markers.unlock = function(){
    locks.reload_markers.locked = false;
}
locks.reload_markers.lock = function(){
    locks.reload_markers.locked = true;
}

/**
 * Timer is to buffer one function call at a time
 */
var timers = new Object();
timers.reload_markers = false;
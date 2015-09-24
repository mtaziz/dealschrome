(function($){

    function initialize() {
        if(map == null || map == undefined){
            attachMapPrototypes();
            var myOptions = {
                zoom: 14,
                center: new google.maps.LatLng(userLat,userLng),
                mapTypeControl: false,
                rotateControl: false,
                panControl: false,
                zoomControl: false,
                overviewMapControl: false,
                scaleControl: false,
                streetViewControl: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
            determineUserLocation();
        
            var reload_markers_timer;
            
            google.maps.event.addListener(map, 'bounds_changed', function(){
                clearTimeout(reload_markers_timer);
                reload_markers_timer = setTimeout(function(){
                    reload_markers(0);
                },1000);
            });
            
        } else {
            reload_markers(0);
        }
    }
    
    function reload_markers(delay){
        clearTimeout(timers.reload_markers);
        timers.reload_markers = setTimeout(function(){
            reload_markers_internal();
        },delay);
    }
    
    function reload_markers_internal() {
        mapBounds = map.getBounds();
        mapCenter = mapBounds.getCenter();
        mapRadius = mapBounds.getRadius();
        
        init_load_deals();
    }
    
    function init_load_deals(){
        if(locks.reload_markers.isLocked() == false){
            locks.reload_markers.lock();
            var qs = {
                'radius' : mapRadius,
                'center' : mapCenter.lat() + ',' + mapCenter.lng(),
                'query' : controlvars.query,
                'price' : controlvars.price,
                'discount': controlvars.discount,
                'category_raw': controlvars.category_raw
            };
            $.get('/deal/map/ajaxDeals',qs,load_deals,'json');
        }
    }
    
    function load_deals(response) {
        if(response == false){
            console.log("response is false");
            $('#changecenter_dialogue').html($('#changecenter_dialogue_content').clone(true)[0]);
            return;
        }
        var data = response.response;
        var info = response.responseHeader;
        queriedTerms[info.params.q] = true;
        
        if(data.numFound == 0){
            $('#changecenter_dialogue').html($('#changecenter_dialogue_content').clone(true)[0]);
        } else {
            $('#changecenter_dialogue').html('');
        }
        var i;
        for(i=0; i<data.numFound; i++) {
            addMarker(data.docs[i],info);
        }
        
        for(i in markers){
            markers[i].filterByCondition();
        }

        locks.reload_markers.unlock();
    }
    
    function addMarker(doc,info) {
        var latlng = doc.location;
        
        if (!markers[latlng]) {
            
            var _conditions = {};
            var i;
            for(i in info.params.fq){
                _conditions[info.params.fq[i]] = true;
            }
            _conditions['q:'+info.params.q] = true;
            _conditions[info.params.d + ":" + info.params.pt] = true;
            
            markers[latlng] = new google.maps.Marker({
                position: location_to_latlng(latlng),
                map: map,
                icon: new google.maps.MarkerImage(get_icon_image(doc.category)),
                draggable: false,
                animation: google.maps.Animation.DROP,
                coords: latlng,
                deal: doc,
                conditions: _conditions
            });
                
            attach_clickmarker_listener(latlng);
            
        } else {
            
            for(i in info.params.fq){
                markers[latlng].conditions[info.params.fq[i]] = true;
            }
            markers[latlng].conditions['q:'+info.params.q] = true;
            markers[latlng].conditions['q:'+info.params.q] = true;
            markers[latlng].conditions[info.params.d + ":" + info.params.pt] = true;
            
        }
    }
    
    function attach_clickmarker_listener(latlng){
        google.maps.event.addListener(markers[latlng], 'click', function(data) {
            if(clickedMarker){
                clickedMarker.setIcon(new google.maps.MarkerImage(get_icon_image(clickedMarker.deal.category,true)));
                clickedMarker.setAnimation(null);    
            }
            clickedMarker = this;
            build_content_html(this.deal);
            this.setAnimation(google.maps.Animation.BOUNCE);
        });
    }
    
    function attachMapPrototypes(){
        attachFilterByConditionPrototype();
        attachContainsBoundsPrototype();
        attachGetRadiusPrototype();
    }

    $(document).ready(function(){
        loadScript();
    });

    window.runGmap = initialize;
    window.reloadmap = reload_markers;

})(jQuery);

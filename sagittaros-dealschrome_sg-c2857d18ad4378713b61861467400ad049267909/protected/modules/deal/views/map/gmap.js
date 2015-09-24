(function($){
    
    var mapBounds;
    var mapCenter;
    var mapRadius;
    var markers = {};
    var infowindow;
    
    function initialize(centerPoint) {
        var myOptions = {
            zoom: 14,
            center: centerPoint,
            mapTypeControl: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
        
        var userLocationMarker = new google.maps.Marker({
                    position: centerPoint,
                    map: map,
                    icon: userLocationIcon,
                    draggable: false,
                    animation: google.maps.Animation.DROP
                });
        
        var reload_markers_timer;
        
        google.maps.event.addListener(map, 'bounds_changed', function(){
            clearTimeout(reload_markers_timer);
            reload_markers_timer = setTimeout(function(){
                reload_markers();
            },1000);
        });

    }
    
    function reload_markers() {
        mapBounds = map.getBounds();
        mapCenter = map.getCenter();
        mapRadius = (function(){
            var a_coord = new LatLon(mapBounds.getNorthEast().lat(), mapBounds.getNorthEast().lng());
            var b_coord = new LatLon(mapBounds.getCenter().lat(), mapBounds.getCenter().lng());
            return a_coord.distanceTo(b_coord);
        })();
        
        var qs = {
            'r' : 'deal/search/locationdeals',
            'radius' : mapRadius,
            'center' : mapCenter.lat() + ',' + mapCenter.lng()
        };
        $.get('',qs,load_deals,'json');
    }
    
    function getQs(){
        
    }
    
    function load_deals(data) {
        if(data.numFound == 0){
            $('#changecenter_dialogue').html($('#changecenter_dialogue_content')[0]);
        } else {
            $('#changecenter_dialogue').html('');
        }
                 
        for(var i=0; i<data.numFound; i++) {
            addMarker(data.docs[i]);
        }
            
        function addMarker(doc) {
            var latlng = doc.location;
            var iconImage;

            switch(doc.category){
                case 'Eateries':
                    iconImage = foodIcon;
                    break;
                case 'Beauty & Wellness':
                    iconImage = beautyIcon;
                    break;
                case 'Travel':
                    iconImage = travelIcon;
                    break;
                case 'Fun & Activities':
                    iconImage = funIcon;
                    break;
                case 'Services & Others':
                    iconImage = servicesIcon;
                    break;
                case 'Goods':
                    iconImage = shoppingIcon;
                    break;
            }
                        
            //var markerImage = new google.maps.MarkerImage(iconImage,new google.maps.Size(30,30),null,null,new google.maps.Size(30,30));
            var markerImage = new google.maps.MarkerImage(iconImage);

            if (!markers[latlng]) {
                            
                markers[latlng] = new google.maps.Marker({
                    position: location_to_latlng(latlng),
                    map: map,
                    icon: markerImage,
                    draggable: false,
                    animation: google.maps.Animation.DROP,
                    coords: latlng,
                    deal: doc
                });

                google.maps.event.addListener(markers[latlng], 'click', function(data) {
                    build_content_html(this.deal);
                    console.log(this);
                    this.setAnimation(google.maps.Animation.BOUNCE);
                });
            }
        }
        
        function build_content_html(deal) {
            $('.mapdeal-url').attr('href', deal.url);
            $('.mapdeal-imgsrc').attr('src',deal.imgsrc);
            $('.mapdeal-title').html(deal.title);
            $('#mapdeal').html($('#mapdeal_content')[0]);
        }
    }
    
    function location_to_latlng(location_str) {
        return new google.maps.LatLng(location_str.split(',')[0], location_str.split(',')[1]);
    }

    function loadScript() {
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = "http://maps.googleapis.com/maps/api/js?key=AIzaSyA3rRFHFRuCY_c7M5v7MpYtDtL7h0fElUg&sensor=true&callback=rungmap";
        document.body.appendChild(script);
    }
    
    function determineUserLocation() {
        if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position){
                    //success
                    var userLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude); 
                    initialize(userLocation);
                },
                function(){
                    //failed
                    var userLocation = new google.maps.LatLng(1.294109, 103.784516);
                    initialize(userLocation);
                }
                );
        }
    }
    window.rungmap = determineUserLocation;
    window.onload = loadScript;

})(jQuery);

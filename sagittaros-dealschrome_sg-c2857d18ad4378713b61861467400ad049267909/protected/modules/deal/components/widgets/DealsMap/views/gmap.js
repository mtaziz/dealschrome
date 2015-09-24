var map;
var mapBounds;
var mapCenter;
var mapRadius;
var markers = {};
var clickedMarker;
var userLocationMarker;
var userLat = 1.29991;
var userLng = 103.849426;

(function($){

    function initialize() {
        if(map == null || map == undefined){
            console.log("map is undefined");
            var myOptions = {
                zoom: 14,
                center: new google.maps.LatLng(userLat,userLng),
                mapTypeControl: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
            determineUserLocation();
        
            var reload_markers_timer;
            
            google.maps.event.addListener(map, 'bounds_changed', function(){
                clearTimeout(reload_markers_timer);
                reload_markers_timer = setTimeout(function(){
                    reload_markers();
                },1000);
            });
            
        } else {
            console.log("map is defined");
            reload_markers();
        }
    }
    
    function reload_markers() {
        console.log(map.getDiv());
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

            if (!markers[latlng]) {
                            
                markers[latlng] = new google.maps.Marker({
                    position: location_to_latlng(latlng),
                    map: map,
                    icon: new google.maps.MarkerImage(get_icon_image(doc.category)),
                    draggable: false,
                    animation: google.maps.Animation.DROP,
                    coords: latlng,
                    deal: doc
                });
                
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
        }
        
        function build_content_html(deal) {
            var bought = deal.bought + " sold";
            var price = "$" + deal.price.toFixed(2);
            var worth = "$" + deal.worth.toFixed(2);
            var discount = deal.discount + "%";
            
            var now = Math.round(new Date().getTime()/1000);
            var secsleft = deal.expiry - now;
            var mins = Math.floor(secsleft/60%60);
            var hours = Math.floor(secsleft/3600) % 100;
            var timer_string = hours + 'h' + mins + 'm'; 
            
            $('.mapdeal-url').attr('href', deal.url);
            $('.mapdeal-imgsrc').attr('src',deal.imgsrc);
            $('.mapdeal-title').html(deal.title);
            $('.gmap_after_price').html(price);
            $('.gmap_original_price').html(worth);
            
            $('.gmap_branch').html(deal.dealsource);
            $('.gmap_branch_link').attr('href', 'http://'+deal.dealsource);
            $('.gmap_time_left_span').html(timer_string);
            $('#gmap_deals_div').fadeIn(1000);
            if(parseInt(deal.bought) != 0){
                $('.gmap_sold_number').html(bought);
            } else {
                $('.gmap_sold_number').html("");
            }
            
            
        }
    }
    
    function get_icon_image(category, isDark){
        if(!isDark){
            switch(category){
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
        } else {
            switch(category){
                case 'Eateries':
                    iconImage = foodDarkIcon;
                    break;
                case 'Beauty & Wellness':
                    iconImage = beautyDarkIcon;
                    break;
                case 'Travel':
                    iconImage = travelDarkIcon;
                    break;
                case 'Fun & Activities':
                    iconImage = funDarkIcon;
                    break;
                case 'Services & Others':
                    iconImage = servicesDarkIcon;
                    break;
                case 'Goods':
                    iconImage = shoppingDarkIcon;
                    break;
            }
        }
        return iconImage;
    }
    
    function location_to_latlng(location_str) {
        return new google.maps.LatLng(location_str.split(',')[0], location_str.split(',')[1]);
    }
    
    function determineUserLocation() {
        if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position){
                    //success
                    userLat = position.coords.latitude;
                    userLng = position.coords.longitude;
                    changeMapCenter();
                    userLocationMarker = new google.maps.Marker({
                        position: new google.maps.LatLng(userLat,userLng),
                        map: map,
                        icon: userLocationIcon,
                        draggable: false,
                        animation: google.maps.Animation.DROP,
                        zIndex: 999
                    });
        
                    var infowindow = new google.maps.InfoWindow({
                        content: 'You are here'
                    });
        
                    google.maps.event.addListener(userLocationMarker, 'mouseover', function() {
                        infowindow.open(map,userLocationMarker);
                    });
                    google.maps.event.addListener(userLocationMarker, 'mouseout', function() {
                        infowindow.close();
                    });
                },
                function(){
                //failed
                }
                );
        }
    }
    
    function changeMapCenter(){
        map.setCenter(new google.maps.LatLng(userLat,userLng));
        map.setZoom(14);
    }
    
    function focusToDealZone(){
        var lat = 1.29991;
        var lng = 103.849426;
        map.setCenter(new google.maps.LatLng(lat,lng));
        map.setZoom(14);
    }
    
    window.rungmap = initialize;
    window.focusToDealZone = focusToDealZone;

})(jQuery);


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
                console.log("map navigator service doesnt exist");
            }
            );
    }
}
    
function changeMapCenter(){
    map.setCenter(new google.maps.LatLng(userLat,userLng));
    map.setZoom(14);
}
    
function focusToDealZone(){
    controlvars = {
        'query': '*',
        'price': '*',
        'category_raw': '*',
        'discount': '*'
    }
    var lat = 1.29991;
    var lng = 103.849426;
    map.setCenter(new google.maps.LatLng(lat,lng));
    map.setZoom(14);
}
    
function loadScript() {
    var script = document.createElement("script");
    script.type = "text/javascript";
    script.src = "http://maps.googleapis.com/maps/api/js?key=AIzaSyA3rRFHFRuCY_c7M5v7MpYtDtL7h0fElUg&sensor=true&callback=runGmap";
    document.body.appendChild(script);
}
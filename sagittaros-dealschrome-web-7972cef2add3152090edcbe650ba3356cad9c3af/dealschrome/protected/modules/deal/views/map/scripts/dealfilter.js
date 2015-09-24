function attachFilterByConditionPrototype(){
    google.maps.Marker.prototype.filterByCondition = function(){
        if(
            ('category_raw:"'+controlvars.category_raw+'"' in this.conditions || 'category_raw:*' in this.conditions) &&
            'price:'+controlvars.price in this.conditions &&
            'discount:'+controlvars.discount in this.conditions &&
            'q:'+controlvars.query in this.conditions
        ){
            this.setVisible(true);
        } else {
            this.setVisible(false);
        }
    }
}

function attachContainsBoundsPrototype(){
    google.maps.LatLngBounds.prototype.containsBounds = function(bounds){
        var joinedBounds = this.union(bounds);
        return this.equals(joinedBounds);
    }
}

function attachGetRadiusPrototype(){
    google.maps.LatLngBounds.prototype.getRadius = function(){
        var ne = this.getNorthEast();
        var ce = this.getCenter();
        var neCoord = new LatLon(ne.lat(), ne.lng());
        var ceCoord = new LatLon(ce.lat(), ce.lng());
        var radius = neCoord.distanceTo(ceCoord);
        return radius;
    }
}
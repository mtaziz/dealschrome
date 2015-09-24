<?php

class DealsMap extends DealWidget {

    public function run() {
        $iconsDir = Yii::app()->theme->baseUrl. '/images/map_icons';
        $icons = array(
            'beauty' => $iconsDir . '/beauty-w36.png',
            'food' => $iconsDir . '/food-w36.png',
            'fun' => $iconsDir . '/activities-w36.png',
            'shopping' => $iconsDir . '/shopping-w36.png',
            'travel' => $iconsDir . '/travel-w36.png',
            'services' => $iconsDir . '/workshop-w36.png',
            'beauty_dark' => $iconsDir . '/beauty-w36-onclick.png',
            'food_dark' => $iconsDir . '/food-w36-onclick.png',
            'fun_dark' => $iconsDir . '/activities-w36-onclick.png',
            'shopping_dark' => $iconsDir . '/shopping-w36-onclick.png',
            'travel_dark' => $iconsDir . '/travel-w36-onclick.png',
            'services_dark' => $iconsDir . '/workshop-w36-onclick.png',
            'userLocation' => $iconsDir . '/userLocation.png',
        );

        AssetLoader::loadInline('iconsUrl', $this->publishPhpVars($icons));
        $gmapUrl = "http://maps.googleapis.com/maps/api/js?key=AIzaSyA3rRFHFRuCY_c7M5v7MpYtDtL7h0fElUg&sensor=true";
        AssetLoader::loadExternal($gmapUrl);
        AssetLoader::load($this->viewPath.'/latlon.js');
        AssetLoader::load($this->viewPath.'/gmap.js');
        $this->render('dealsmap');
    }

    private function publishPhpVars($vars) {
        $script = "
        var beautyIcon = '{$vars['beauty']}';
        var foodIcon = '{$vars['food']}';
        var funIcon = '{$vars['fun']}';
        var shoppingIcon = '{$vars['shopping']}';
        var travelIcon = '{$vars['travel']}';
        var servicesIcon = '{$vars['services']}';
        var userLocationIcon = '{$vars['userLocation']}';
        var beautyDarkIcon = '{$vars['beauty_dark']}';
        var foodDarkIcon = '{$vars['food_dark']}';
        var funDarkIcon = '{$vars['fun_dark']}';
        var shoppingDarkIcon = '{$vars['shopping_dark']}';
        var travelDarkIcon = '{$vars['travel_dark']}';
        var servicesDarkIcon = '{$vars['services_dark']}';
        ";
        return $script;
    }

}
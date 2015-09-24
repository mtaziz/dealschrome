<?php

class MapController extends DealController {

    public $layout = '//layouts/html_map';

    public function actionIndex() {
        $this->pageTitle = "Dealschrome - Map";
        $iconsDir = Yii::app()->theme->baseUrl . '/images/map_icons';
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
        AssetLoader::load($this->viewPath . '/scripts/globalvars.js');
        AssetLoader::load($this->viewPath . '/scripts/latlon.js');
        AssetLoader::load($this->viewPath . '/scripts/gmap_utils.js');
        AssetLoader::load($this->viewPath . '/scripts/dealfilter.js');
        AssetLoader::load($this->viewPath . '/scripts/gmap.js');
        AssetLoader::load($this->viewPath . '/scripts/queryform.js');
        AssetLoader::load($this->viewPath . '/scripts/mapcontroller.js');
        $this->render('page_map');
    }

    public function actionAjaxDeals($center, $radius) {
        $is_urlencoded = TRUE;
        $params = $this->resolve_map_request_vars($is_urlencoded);
        extract($params);
        $solr = new DealModel;
        try {
            $solr_result = $solr->getDealsFromLocation($center, $radius, $query, $filters);
            echo json_encode($solr_result);
        } catch (Exception $e) {
            echo $e->getTraceAsString();
            echo "unable to query deals from location";
        }
        Yii::app()->end();
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
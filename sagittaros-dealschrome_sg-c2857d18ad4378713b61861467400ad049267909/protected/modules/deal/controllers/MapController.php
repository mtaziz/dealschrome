<?php

class MapController extends DealController {

    public $layout = '//layouts/html';

    public function actionIndex() {
        $this->pageTitle = "Dealschrome - Map";
        $iconsDir = Yii::app()->theme->baseUrl. '/images/map_icons';
         $icons = array(
            'beauty' => $iconsDir . '/beauty-w36.png',
            'food' => $iconsDir . '/food-w36.png',
            'fun' => $iconsDir . '/activities-w36.png',
            'shopping' => $iconsDir . '/shopping-w36.png',
            'travel' => $iconsDir . '/travel-w36.png',
            'services' => $iconsDir . '/workshop-w36.png',
            'userLocation' => $iconsDir . '/userLocation.png',
        );

        AssetLoader::loadInline('iconsUrl', $this->publishPhpVars($icons));
        AssetLoader::load($this->viewPath.'/latlon.js');
        AssetLoader::load($this->viewPath.'/dialogues.js');
        AssetLoader::load($this->viewPath.'/gmap.js');
        $this->render('page_map');
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
        ";
        return $script;
    }
}
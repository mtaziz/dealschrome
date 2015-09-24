<?php

class JsScriptsExporter extends CWidget{
    
    /**
     * Usage:
     *  run this widget at html view file 
     */
    
    public function run() {
        AssetLoader::load($this->viewPath.'/scripts/jquery.cookie.js');
        AssetLoader::load($this->viewPath.'/scripts/email_subscription.js');
        AssetLoader::load($this->viewPath.'/scripts/maincontroller.js');
        //AssetLoader::load($this->viewPath.'/scripts/userrules.js');
        //AssetLoader::load($this->viewPath.'/scripts/uservoice.js');
        //AssetLoader::load($this->viewPath.'/scripts/jquery.masonry.js');
        //AssetLoader::load($this->viewPath.'/scripts/pin_view_caption.js');
    }
    
}

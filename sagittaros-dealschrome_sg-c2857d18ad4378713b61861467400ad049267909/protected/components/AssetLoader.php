<?php

class AssetLoader extends CComponent{

    /**
     *
     * @param type $path 
     *  path to the file
     * @return type string
     *  url to the file 
     */
    public static function load($filepath) {
        $path = Yii::app()->getAssetManager()->publish($filepath);

        if (strpos($path, 'js') !== false)
            return Yii::app()->clientScript->registerScriptFile($path,CClientScript::POS_END);
        else if (strpos($path, 'css') !== false)
            return Yii::app()->clientScript->registerCssFile($path);
        else 
            return $path;
    }
    
    public static function loadExternal($url){
        if (strpos($url, 'js') !== false)
            return Yii::app()->clientScript->registerScriptFile($url,CClientScript::POS_END);
        else if (strpos($url, 'css') !== false)
            return Yii::app()->clientScript->registerCssFile($url);
    }
    
    public static function loadInline($id, $script) {
        Yii::app()->clientScript->registerScript(
                $id, $script,CClientScript::POS_END
        );
    }
    
    private static function publish($filepath) {
        return Yii::app()->getAssetManager()->publish($filepath);
    }

}


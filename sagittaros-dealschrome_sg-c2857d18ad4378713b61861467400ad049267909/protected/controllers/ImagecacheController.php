<?php

class ImagecacheController extends Controller {

    public function actionIndex($url, $width) {
        $imcache = new ImageCache();
        header('Content-type: image/jpeg');
        if ($imcache->imageInCache($url, $width)) {
            $imagelink = $imcache->getImageLink($url, $width);
            readfile($imagelink);
        } else {
            readfile($url);
            $imcache->getImageLink($url, $width);
        }
    }

}
<?php

class ImageCache {

    protected $image;
    protected $image_type;
    protected $root;
    protected $savepath;

    public function __construct() {
        $this->root = '/var/www/dealschrome/'.Yii::app()->theme->baseUrl . '/imagecache';
        chdir($this->root);
        $storingtime = 86400*7;
        $foldername = round(time() / $storingtime);
        if (!file_exists($foldername)) {
            // remove all old cache
            Filehelper::cleandir(getcwd());
            // create a cache for today
            Filehelper::mkdir($foldername);
        }
        $this->savepath = $foldername;
    }
    
    public function imageInCache($url, $width){
        $imagename = Filehelper::cleanseUrl($url);
        if(!file_exists("$this->savepath/$width")){
            return false;
        }
        
        if(!file_exists("$this->savepath/$width/$imagename.jpg")) {
            return false;
        }
        
        return true;
    }

    public function getImageLink($url, $width) {
        $imagename = Filehelper::cleanseUrl($url);
        if(!file_exists("$this->savepath/$width")){
            Filehelper::mkdir("$this->savepath/$width");
        }
        
        if(!file_exists("$this->savepath/$width/$imagename.jpg")) {
            $this->load($url);
            $this->resizeToWidth($width);
            $this->save("$this->savepath/$width/$imagename.jpg");
        }
        return $this->root . "/$this->savepath/$width/$imagename.jpg";
    }

    protected function load($filename) {
        $image_info = getimagesize($filename);
        $this->image_type = $image_info[2];
        if ($this->image_type == IMAGETYPE_JPEG) {
            $this->image = imagecreatefromjpeg($filename);
        } elseif ($this->image_type == IMAGETYPE_GIF) {
            $this->image = imagecreatefromgif($filename);
        } elseif ($this->image_type == IMAGETYPE_PNG) {
            $this->image = imagecreatefrompng($filename);
        }
    }

    protected function save($filename, $image_type = IMAGETYPE_JPEG, $compression = 80, $permissions = null) {
        if ($image_type == IMAGETYPE_JPEG) {
            imagejpeg($this->image, $filename, $compression);
        } elseif ($image_type == IMAGETYPE_GIF) {
            imagegif($this->image, $filename);
        } elseif ($image_type == IMAGETYPE_PNG) {
            imagepng($this->image, $filename);
        }
        if ($permissions != null) {
            chmod($filename, $permissions);
        }
    }

    protected function output($image_type = IMAGETYPE_JPEG) {
        if ($image_type == IMAGETYPE_JPEG) {
            imagejpeg($this->image);
        } elseif ($image_type == IMAGETYPE_GIF) {
            imagegif($this->image);
        } elseif ($image_type == IMAGETYPE_PNG) {
            imagepng($this->image);
        }
    }

    protected function getWidth() {
        return imagesx($this->image);
    }

    protected function getHeight() {
        return imagesy($this->image);
    }

    protected function resizeToHeight($height) {
        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize($width, $height);
    }

    protected function resizeToWidth($width) {
        $ratio = $width / $this->getWidth();
        $height = $this->getheight() * $ratio;
        $this->resize($width, $height);
    }

    protected function scale($scale) {
        $width = $this->getWidth() * $scale / 100;
        $height = $this->getheight() * $scale / 100;
        $this->resize($width, $height);
    }

    protected function resize($width, $height) {
        $new_image = imagecreatetruecolor($width, $height);
        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $new_image;
    }

}
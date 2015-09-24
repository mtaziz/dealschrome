<?php

class Filehelper {

    /**
     * cleanse a url to exclude non word tokens
     * @param type $url
     * @return type 
     */
    public static function cleanseUrl($url) {
        return preg_replace("#\W#", "", $url);
    }

    /**
     * recursively remove a directory
     * @param type $dir 
     */
    public static function rrmdir($dir) {
        if (is_dir($dir)) {
            self::cleandir($dir);
            rmdir($dir);
        }
    }

    /**
     * clean a directory recursively
     * @param type $dir 
     */
    public static function cleandir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir")
                        self::rrmdir($dir . "/" . $object);
                    else
                        unlink($dir . "/" . $object);
                }
            }
            reset($objects);
        }
    }

    public static function mkdir($dirname) {
        return mkdir($dirname, 0777, true);
    }

}


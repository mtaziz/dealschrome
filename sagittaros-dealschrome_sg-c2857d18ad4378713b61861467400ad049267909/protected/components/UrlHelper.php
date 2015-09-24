<?php

class UrlHelper {

    public $url;
    public $queryString;
    public $queryArray;

    public function UrlHelper() {
        $this->url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        $this->queryString = $_SERVER['REDIRECT_QUERY_STRING'];
        $this->queryArray = $_GET;
        $this->path = $_SERVER['REDIRECT_URL'];
    }

    /**
     *
     * @param array $queryNVP
     * @return array newQueryArray 
     */
    public function mergeUrlQuery(array $queryNVP) {
        $q = $this->queryArray;
        foreach ($queryNVP as $k => $v) {
            $q[$k] = $v;
        }
        $newUrl = $this->path . '?' . http_build_query($q);
        $return = new stdClass();
        $return->newUrl = $newUrl;
        $return->newQueries = $q;
        return $return;
    }

    public static function formQueryUrl($urlArr = array()) {
        $defaultQuery = array(
            '/deal/search/full',
        );
        return array_merge($defaultQuery, $urlArr);
    }

}


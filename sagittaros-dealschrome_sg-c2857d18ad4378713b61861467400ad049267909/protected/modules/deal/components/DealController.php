<?php

/**
 * Base controller for deal module 
 */
class DealController extends CController {

    protected function resolve_request_vars($is_urlencoded) {
        $get_param_func = ($is_urlencoded) ? 'get_encoded_param' : 'get_param';

        $rawquery = $this->{$get_param_func}('query', '*:*');
        $price = $this->{$get_param_func}('price', '*');
        $discount = $this->{$get_param_func}('discount', '*');
        $category = $this->{$get_param_func}('category_raw', '*');
        $dealsource_raw = $this->{$get_param_func}('dealsource_raw', '*');
        $sort = $this->{$get_param_func}('sort', '');
        $rows = $this->{$get_param_func}('rows', 32);
        $offset = $this->{$get_param_func}('offset', 0);
        $layout = $this->{$get_param_func}('layout', '');

        if ($layout != 'list' && $layout != 'grid' && $layout != 'pin') {
            $layout = 'grid';
        }

        $query = $this->clean_query($rawquery);

        if ($category != '*') {
            $category = '"' . $category . '"';
        }

        $query_options = array(
            'fq' => array(
                'price:' . $price,
                'discount:' . $discount,
                'category_raw:' . $category,
                'dealsource_raw:' . $dealsource_raw,
                'expiry:['.  time() .' TO *]',
            ),
            'sort' => $sort,
        );
        
        return array(
            'layout' => $layout,
            'query' => $query,
            'query_options' => $query_options,
            'rows' => intval($rows),
            'offset' => intval($offset),
        );
    }

    protected function get_param($name, $default) {
        return (isset($_REQUEST[$name])) ? $_REQUEST[$name] : $default;
    }

    protected function get_encoded_param($name, $default) {
        return (isset($_REQUEST[$name])) ? urldecode($_REQUEST[$name]) : $default;
    }

    protected function clean_query($query) {
        return str_replace(":", " ", $query);
    }
    
}


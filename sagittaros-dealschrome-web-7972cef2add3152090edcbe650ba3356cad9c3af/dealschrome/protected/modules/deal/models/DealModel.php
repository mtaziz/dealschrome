<?php

class DealModel {

    public $solr;

    public function __construct() {
        $this->solr = new Solr('search-engine');
    }

    public function getTotalDeals() {
        return $this->solr->query("*:*", array('fq'=>array('expiry:['.  time() .' TO *]')), 0, 0)->response->numFound;
    }
    
    public function isTermExists($term) {
        $term = $this->filterQuery($term);
        $term = $this->processQuery($term);
        return $this->solr->query($term, array('fq'=>array('expiry:['.  time() .' TO *]')), 0, 0)->response->numFound;
    }

    public function query($query, $options = array(), $rows = 300, $offset = 0) {
        $query = $this->filterQuery($query);
        $tokens = explode(" ",$query);
        $isValidQuery = true;
        foreach ($tokens as $tok) {
            if(strlen($tok) < 5) $isValidQuery = false;
        }
        if($isValidQuery) TopSearch::saveTerm($query);
        $query = $this->processQuery($query);
        return $this->solr->query($query, $options, $rows, $offset)->response;
    }

    public function queryWithSpellCheck($query, $options = array(), $rows = 300, $offset = 0) {
        $query = $this->filterQuery($query);
        $tokens = explode(" ",$query);
        $isValidQuery = true;
        foreach ($tokens as $tok) {
            if(strlen($tok) < 5) $isValidQuery = false;
        }
        if($isValidQuery) TopSearch::saveTerm($query);
        $query = $this->processQuery($query);
        $options['spellcheck'] = 'true';
        $options['spellcheck.count'] = 10;
        $options['spellcheck.collate'] = 'true';
        // spellcheck built has an overhead of rebuilding the spell index,
        // we avoid hitting too frequent by using probability of 1/90
        $luckyNumber = mt_rand(0, 90);
        if ($luckyNumber == 8) {
            $options['spellcheck.build'] = 'true';
        }
        $result = $this->solr->query($query, $options, $rows, $offset);
        $response = $result->response;

        if (
                property_exists($result, 'spellcheck') &&
                property_exists($result->spellcheck, 'suggestions') &&
                property_exists($result->spellcheck->suggestions, 'collation')
        ) {
            $suggestion = $result->spellcheck->suggestions->collation;
            $fullsuggestion = $result->spellcheck;
        } else {
            $suggestion = NULL;
            $fullsuggestion = NULL;
        }
        $return = new stdClass();
        $return->response = $response;
        $return->suggestion = str_replace('+', '', $suggestion);
        $return->fullsuggestion = $fullsuggestion;
        $return->highlighting = property_exists($result, 'highlighting') ? $result->highlighting : NULL;

        return $return;
    }

    public function getFacet($prefix, $field, $limit, $minCount) {
        $options['facet'] = 'on';
        $options['facet.limit'] = $limit;
        $options['facet.mincount'] = $minCount;
        $options['facet.field'] = $field;
        $options['facet.prefix'] = $prefix;
        $result = $this->solr->query('*:*', $options, 0, 0);
        $response = (array) $result->facet_counts->facet_fields->{$field};

        return array_keys($response);
    }

    public function getSuggestions($query) {
        $options = array(
            'qt' => '/suggest',
            'spellcheck.count' => 100,
        );

        $result = $this->solr->query($query, $options, 0, 0);
        
        if (property_exists($result, 'spellcheck') && property_exists($result->spellcheck->suggestions, $query)) {
            $ret = array();
            foreach($result->spellcheck->suggestions as $word){
                $ret = array_merge($ret, $word->suggestion);
            }
            return $ret;
        } else {
            return array();
        }
    }

    public function getDealsFromLocation($center, $radius, $query="*:*", $filters=array()) {
        $default_filters = array('{!geofilt}');
        $fq = array_merge($default_filters,$filters);
        $options = array(
            'fq' => $fq,
            'sfield' => 'location',
            'pt' => $center,
            'd' => $radius,
            'sort' => 'geodist() asc',
            'fl' => 'location,title,imgsrc,category,url,price,worth,discount,dealsource,bought,expiry',
        );
        $rows = 500;
        return $this->solr->query($query, $options, $rows);
    }

    private function filterQuery($query) {
        $invalids = array("," , "[", "]" , ":" , "(" , ")" , "*" , "!" , "\"" , "&" , "-" , "+" , "=" , "^" , "~" , "`" , "|");
        $query = str_replace($invalids, "", $query);
        $query = trim($query);
        return $query;
    }
    
    private function processQuery($query) {
        if (!$query) {
            
            $query = '*:*';
        }
        if (get_magic_quotes_gpc() == 1) {
            $query = stripslashes($query);
        }

        $qArr = explode(' ', $query);
        $query = '';
        foreach ($qArr as $q) {
            if ($q != '*' && $q != '*:*')
                $q = ' +' . $q;
            $query .= $q;
        }
        $query = trim($query);
        return $query;
    }

}

